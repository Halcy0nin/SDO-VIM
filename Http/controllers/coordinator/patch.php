<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

// Get school filter, date range, search term, and clear filter option
$schoolFilterValue = $_POST['schoolFilterValue'] ?? 'All School';
$schoolSearchValue = $_POST['schoolSearchValue'] ?? null; // Get search value
$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;
$clearFilter = isset($_POST['clearFilter']);
$searchTerm = trim($_POST['search'] ?? '');

// Determine the school name to filter by (Priority: schoolSearchValue > schoolFilterValue)
$schoolNameToFilter = !empty($schoolSearchValue) ? $schoolSearchValue : $schoolFilterValue;

// Notification count query
$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND created_by != :user_id 
', [
    'user_id' => get_uid(),
])->find();

$notificationCount = $notificationCountQuery['total'] > 5 ? '5+' : $notificationCountQuery['total'];

// Initialize SQL conditions and parameters
$params = [
    'search_code' => '%' . strtolower($searchTerm) . '%',
    'search_article' => '%' . strtolower($searchTerm) . '%',
    'search_desc' => '%' . strtolower($searchTerm) . '%',
    'search_school' => '%' . strtolower($searchTerm) . '%',
];
$conditions = [];

// Apply filter based on priority

// Check if school filter is applied
if ($schoolNameToFilter !== 'All School') {
    // If school filter is applied, reset search term condition
    $conditions[] = "s.school_name = :schoolFilterValue";
    $params['schoolFilterValue'] = $schoolNameToFilter;
} elseif ($searchTerm) {
    // If search term is provided, apply it and ignore the school filter
    $conditions[] = "(s.school_name LIKE :searchTerm)";
    $params['searchTerm'] = '%' . $searchTerm . '%';
}

if ($clearFilter) {
    $startDate = null;
    $endDate = null;
}

// Apply date filter only if clearFilter was not clicked
if (!$clearFilter) {
    if ($startDate && $endDate) {
        $conditions[] = "si.date_acquired BETWEEN :startDate AND :endDate";
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "si.date_acquired <= :endDate";
        $params['endDate'] = $endDate;
    }
}

// Combine search conditions
$conditions[] = "(
    si.item_code LIKE :search_code OR
    si.item_article LIKE :search_article OR
    si.item_desc LIKE :search_desc OR
    s.school_name LIKE :search_school
)";

$combinedCondition = $conditions ? " WHERE " . implode(" AND ", $conditions) : "";

// Helper function to run count queries with optional conditions
function runCountQuery($db, $baseQuery, $condition, $params) {
    return $db->query($baseQuery . $condition, $params)->find()['total_count'] ?? 0;
}

// Count total equipment
$total_equipment_count = runCountQuery(
    $db,
    "SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id ",
    "$combinedCondition 
    AND
    item_request_status = 1
    AND 
    item_assigned_status = 2
    AND 
    si.is_archived = 0",
    $params
);

// Count total working equipment
$total_working_count = runCountQuery(
    $db,
    'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id AND si.item_status = 1',
    "$combinedCondition 
    AND
    item_request_status = 1
    AND 
    item_assigned_status = 2
    AND 
    si.is_archived = 0",
    $params
);

// Count total need repair equipment
$total_repair_count = runCountQuery(
    $db,
    'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id AND si.item_status = 2',
    "$combinedCondition 
    AND
    item_request_status = 1
    AND 
    item_assigned_status = 2
    AND 
    si.is_archived = 0",
    $params
);

// Count total condemned equipment
$total_condemned_count = runCountQuery(
    $db,
    'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id AND si.item_status = 3',
    "$combinedCondition 
    AND
    item_request_status = 1
    AND 
    item_assigned_status = 2
    AND 
    si.is_archived = 0",
    $params
);

// Item Article Counts (Top 5)
$itemArticleCountQuery = $db->query('
    SELECT si.item_article, COUNT(*) AS article_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id
    WHERE si.item_article IS NOT NULL' . ($combinedCondition ? ' AND ' . implode(' AND ', $conditions) : '') . '
    AND
    item_request_status = 1
    AND 
    item_assigned_status = 2
    AND 
    si.is_archived = 0
    GROUP BY si.item_article
    ORDER BY article_count DESC
    LIMIT 5',
    $params
);
$itemArticleCounts = $itemArticleCountQuery->get();

$articleNames = array_column($itemArticleCounts, 'item_article');
$articleCounts = array_column($itemArticleCounts, 'article_count');

$articleNamesJson = json_encode($articleNames);
$articleCountsJson = json_encode($articleCounts);

// Map item statuses
$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

// Status Labels and Counts for chart
$itemStatusCountQuery = $db->query('
    SELECT si.item_status, COUNT(*) AS status_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id' . ($combinedCondition ? ' AND ' . implode(' AND ', $conditions) : '') . '
    GROUP BY si.item_status',
    $params
);
$itemStatusCounts = $itemStatusCountQuery->get();

$statusLabels = [];
$statusCounts = [];
foreach ($itemStatusCounts as $status) {
    $statusLabels[] = $statusMap[$status['item_status']] ?? 'Unknown';
    $statusCounts[] = $status['status_count'];
}

$statusLabelsJson = json_encode($statusLabels);
$statusCountsJson = json_encode($statusCounts);

// Monthly Item Acquisitions (within or up to endDate)
$itemArticlePerMonthQuery = $db->query('
    SELECT 
        DATE_FORMAT(date_acquired, "%b") AS month,
        COUNT(item_article) AS item_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id
    WHERE si.item_article IS NOT NULL' . ($combinedCondition ? ' AND ' . implode(' AND ', $conditions) : '') . '
    AND
    item_request_status = 1
    AND 
    item_assigned_status = 2
    AND 
    si.is_archived = 0
    GROUP BY month
    ORDER BY MIN(date_acquired)',
    $params
);
$itemArticlePerMonth = $itemArticlePerMonthQuery->get();

$months = array_column($itemArticlePerMonth, 'month');
$itemCounts = array_column($itemArticlePerMonth, 'item_count');

$monthsJson = json_encode($months);
$itemCountsJson = json_encode($itemCounts);

// Populate school dropdown content
$schoolDropdownContent = $db->query("SELECT school_name FROM schools")->get();

// Render view with the data
view('coordinator/create.view.php', [
    'heading' => 'Dashboard',
    'schoolName' => $schoolNameToFilter, // Set the determined school name
    'notificationCount' => $notificationCount,
    'totalEquipment' => $total_equipment_count,
    'totalWorking' => $total_working_count,
    'totalRepair' => $total_repair_count,
    'totalCondemned' => $total_condemned_count,
    'statusMap' => $statusMap,
    'statusLabels' => $statusLabelsJson,
    'statusCounts' => $statusCountsJson,
    'months' => $monthsJson,
    'itemCountsPerMonth' => $itemCountsJson,
    'search' => $searchTerm,
    'articleNames' => $articleNamesJson,
    'articleCounts' => $articleCountsJson,
    'schoolDropdownContent' => $schoolDropdownContent,
    'startDate' => $startDate,
    'endDate' => $endDate,
]);

?>
