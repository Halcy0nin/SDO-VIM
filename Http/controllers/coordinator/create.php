<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

//Total Equipment
$total_equipment_count_query = $db->query('
    SELECT COUNT(item_code) as total_count
    FROM school_inventory'
)->find();
$total_equipment_count = $total_equipment_count_query['total_count'] ?? 0;

//Total Working Equipment
$total_working_count_query = $db->query('
    SELECT COUNT(item_code) as total_count
    FROM school_inventory WHERE item_status = 1'
)->find();
$total_working_count = $total_working_count_query['total_count'] ?? 0;

//Total Need Repair Equipment
$total_repair_count_query = $db->query('
    SELECT COUNT(item_code) as total_count
    FROM school_inventory WHERE item_status = 2'
)->find();
$total_repair_count = $total_repair_count_query['total_count'] ?? 0;

//Total Condemned Equipment
$total_condemned_count_query = $db->query('
    SELECT COUNT(item_code) as total_count
    FROM school_inventory WHERE item_status = 3'
)->find();
$total_condemned_count = $total_condemned_count_query['total_count'] ?? 0;


//Item Article
$itemArticleCountQuery = $db->query('
    SELECT item_article, COUNT(*) as article_count
    FROM school_inventory
    WHERE item_article IS NOT NULL
    GROUP BY item_article
    ORDER BY article_count DESC
    LIMIT 5
');

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
    SELECT item_status, COUNT(*) as status_count
    FROM school_inventory
    WHERE item_status IN (1, 2, 3)
    GROUP BY item_status
');

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
    FROM 
        school_inventory
    WHERE 
        item_article IS NOT NULL
    GROUP BY 
        month
    ORDER BY 
        MIN(date_acquired)

');

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

$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND  created_by != :user_id 
',[
    'user_id' => get_uid(),
])->find();

// Extract the total count
$notificationCount = $notificationCountQuery['total'];

if ($notificationCount > 5){
    $notificationCount = '5+';
};

view('coordinator/create.view.php', [
    'heading' => 'Dashboard',
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
    'schoolDropdownContent' => $schoolDropdownContent
]);

?>
