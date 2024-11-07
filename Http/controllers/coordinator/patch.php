<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

// Get notification count
$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND created_by != :user_id 
', [
    'user_id' => get_uid(),
])->find();

$notificationCount = $notificationCountQuery['total'] > 5 ? '5+' : $notificationCountQuery['total'];

// Get school filter and date range values
$schoolFilterValue = $_POST['schoolFilterValue'] ?? 'All School';
$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;

// Initialize parameters array and conditions for SQL
$params = [];
$conditions = [];

// Apply school filter if not 'All School'
if ($schoolFilterValue !== 'All School') {
    $conditions[] = "s.school_name = :schoolFilterValue";
    $params['schoolFilterValue'] = $schoolFilterValue;
}

// Apply date filter based on provided dates
if ($startDate && $endDate) {
    // Filter within a specific range
    $conditions[] = "si.date_acquired BETWEEN :startDate AND :endDate";
    $params['startDate'] = $startDate;
    $params['endDate'] = $endDate;
} elseif ($endDate) {
    // Cumulative filter up to endDate only
    $conditions[] = "si.date_acquired <= :endDate";
    $params['endDate'] = $endDate;
}

$combinedCondition = $conditions ? " WHERE " . implode(" AND ", $conditions) : "";

// Helper function to run count queries with optional conditions
function runCountQuery($db, $baseQuery, $condition, $params) {
    return $db->query($baseQuery . $condition, $params)->find()['total_count'] ?? 0;
}

// Total Equipment (cumulative or within range based on dates)
$total_equipment_count = runCountQuery(
    $db,
    'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id',
    $combinedCondition,
    $params
);

// Total Working Equipment
$total_working_count = runCountQuery(
    $db,
    'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id AND si.item_status = 1',
    $combinedCondition,
    $params
);

// Total Need Repair Equipment
$total_repair_count = runCountQuery(
    $db,
    'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id AND si.item_status = 2',
    $combinedCondition,
    $params
);

// Total Condemned Equipment
$total_condemned_count = runCountQuery(
    $db,
    'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si JOIN schools AS s ON si.school_id = s.school_id AND si.item_status = 3',
    $combinedCondition,
    $params
);

// Item Article Counts (Top 5)
$itemArticleCountQuery = $db->query('
    SELECT si.item_article, COUNT(*) AS article_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id
    WHERE si.item_article IS NOT NULL' . ($combinedCondition ? ' AND ' . implode(' AND ', $conditions) : '') . '
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

// Item Status Counts
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
$statusMapping = [1 => 'Working', 2 => 'Need Repair', 3 => 'Condemned'];
foreach ($itemStatusCounts as $status) {
    $statusLabels[] = $statusMapping[$status['item_status']] ?? 'Unknown';
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
    GROUP BY month
    ORDER BY MIN(date_acquired)',
    $params
);
$itemArticlePerMonth = $itemArticlePerMonthQuery->get();

$months = array_column($itemArticlePerMonth, 'month');
$itemCounts = array_column($itemArticlePerMonth, 'item_count');

$monthsJson = json_encode($months);
$itemCountsJson = json_encode($itemCounts);

// Get school dropdown options
$schoolDropdownContent = $db->query('SELECT school_name FROM schools')->get();

// Render the view
view('coordinator/create.view.php', [
    'heading' => 'Dashboard',
    'schoolName' => $schoolFilterValue,
    'notificationCount' => $notificationCount,
    'totalEquipment' => $total_equipment_count,
    'totalWorking' => $total_working_count,
    'totalRepair' => $total_repair_count,
    'totalCondemned' => $total_condemned_count,
    'articleNames' => $articleNamesJson,
    'articleCounts' => $articleCountsJson,
    'statusLabels' => $statusLabelsJson,
    'statusCounts' => $statusCountsJson,
    'months' => $monthsJson,
    'itemCountsPerMonth' => $itemCountsJson,
    'schoolDropdownContent' => $schoolDropdownContent,
    'startDate' => $startDate,
    'endDate' => $endDate
]);

?>
