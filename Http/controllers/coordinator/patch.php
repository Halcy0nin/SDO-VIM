<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$schoolFilterValue = $_POST['schoolFilterValue'];

// Prepare base SQL and parameters
$baseQuery = 'SELECT COUNT(si.item_code) AS total_count FROM school_inventory AS si';
$params = [];

// Add conditions based on the selected school
if ($schoolFilterValue !== 'All') {
    $baseQuery .= ' JOIN schools AS s ON si.school_id = s.school_id WHERE s.school_name = :schoolFilterValue';
    $params['schoolFilterValue'] = $schoolFilterValue;
}

// Total Equipment
// Total Equipment
$total_equipment_count_query = $db->query('
    SELECT COUNT(si.item_code) AS total_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id' . 
    ($schoolFilterValue !== 'All' ? ' WHERE s.school_name = :schoolFilterValue' : '')
, $schoolFilterValue !== 'All' ? $params : []);

$total_equipment_count = $total_equipment_count_query->find()['total_count'] ?? 0;

// Total Working Equipment
$total_working_count_query = $db->query('
    SELECT COUNT(si.item_code) AS total_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id' . 
    ($schoolFilterValue !== 'All' ? ' WHERE s.school_name = :schoolFilterValue AND item_status = 1' : ' WHERE item_status = 1')
, $schoolFilterValue !== 'All' ? $params : []);

$total_working_count = $total_working_count_query->find()['total_count'] ?? 0;

// Total Need Repair Equipment
$total_repair_count_query = $db->query('
    SELECT COUNT(si.item_code) AS total_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id' . 
    ($schoolFilterValue !== 'All' ? ' WHERE s.school_name = :schoolFilterValue AND item_status = 2' : ' WHERE item_status = 2')
, $schoolFilterValue !== 'All' ? $params : []);

$total_repair_count = $total_repair_count_query->find()['total_count'] ?? 0;

// Total Condemned Equipment
$total_condemned_count_query = $db->query('
    SELECT COUNT(si.item_code) AS total_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id' . 
    ($schoolFilterValue !== 'All' ? ' WHERE s.school_name = :schoolFilterValue AND item_status = 3' : ' WHERE item_status = 3')
, $schoolFilterValue !== 'All' ? $params : []);

$total_condemned_count = $total_condemned_count_query->find()['total_count'] ?? 0;


// Item Article
$itemArticleCountQuery = $db->query('
    SELECT si.item_article, COUNT(*) AS article_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id
    WHERE si.item_article IS NOT NULL' . ($schoolFilterValue !== 'All' ? ' AND s.school_name = :schoolFilterValue' : '') . '
    GROUP BY si.item_article
    ORDER BY article_count DESC
    LIMIT 5',
    $schoolFilterValue !== 'All' ? $params : []
);

$itemArticleCounts = $itemArticleCountQuery->get();

$articleNames = [];
$articleCounts = [];

foreach ($itemArticleCounts as $item) {
    $articleNames[] = $item['item_article'];
    $articleCounts[] = $item['article_count'];
}

$articleNamesJson = json_encode($articleNames);
$articleCountsJson = json_encode($articleCounts);

// Query to get the count of items by status
$itemStatusCountQuery = $db->query('
    SELECT si.item_status, COUNT(*) AS status_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id
    WHERE si.item_status IN (1, 2, 3' . ($schoolFilterValue !== 'All' ? ' AND s.school_name = :schoolFilterValue' : '') . ')
    GROUP BY si.item_status',
    $schoolFilterValue !== 'All' ? $params : []
);

$itemStatusCounts = $itemStatusCountQuery->get();

$statusLabels = [];
$statusCounts = [];

// Map numeric status to descriptive labels
$statusMapping = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

foreach ($itemStatusCounts as $status) {
    $statusLabels[] = $statusMapping[$status['item_status']];  
    $statusCounts[] = $status['status_count']; 
}

$statusLabelsJson = json_encode($statusLabels);
$statusCountsJson = json_encode($statusCounts);

// Query to get the number of item_articles obtained per month
$itemArticlePerMonthQuery = $db->query('
    SELECT 
        DATE_FORMAT(date_acquired, "%b") AS month,
        COUNT(item_article) AS item_count
    FROM school_inventory AS si
    JOIN schools AS s ON si.school_id = s.school_id
    WHERE si.item_article IS NOT NULL' . ($schoolFilterValue !== 'All' ? ' AND s.school_name = :schoolFilterValue' : '') . '
    GROUP BY 
        month
    ORDER BY 
        MIN(date_acquired)',
    $schoolFilterValue !== 'All' ? $params : []
);

$itemArticlePerMonth = $itemArticlePerMonthQuery->get();

$months = [];
$itemCounts = [];

foreach ($itemArticlePerMonth as $entry) {
    $months[] = $entry['month'];
    $itemCounts[] = $entry['item_count'];
}

$monthsJson = json_encode($months);
$itemCountsJson = json_encode($itemCounts);

$schoolDropdownContent = $db->query('
        SELECT school_name FROM schools;
') ->get();

view('coordinator/create.view.php', [
    'heading' => 'Dashboard',
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
    'schoolDropdownContent' => $schoolDropdownContent
]);


?>