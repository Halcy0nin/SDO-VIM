<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

// Get input values
$startDate = $_POST['yearFilter'] ?? null;
$endDate = $_POST['yearFilter'] ?? null;
$clearFilter = isset($_POST['clearFilter']);
$searchTerm = trim($_POST['search'] ?? '');

if ($clearFilter) {
    $startDate = null;
    $endDate = null;
    $searchTerm = '';
    $conditions = []; // Reset conditions
    $params = []; // Reset parameters
}

// Handle year-only input for date filters
if ($startDate && strlen($startDate) === 4) { // Year input
    $startDate = $startDate . '-01-01'; // Set to January 1st of the year
    $endDate = $endDate . '-12-31'; // Set to December 31st of the year
} elseif ($startDate || $endDate) {
    // Validate and ensure both are complete dates (YYYY-MM-DD format)
    $startDate = $startDate ?: null;
    $endDate = $endDate ?: null;
}

$notificationViewedQuery = $db->query('
    UPDATE notifications
    SET
    viewed = 1
    WHERE viewed IS NULL 
    AND created_by != :user_id 
',[
    'user_id' => get_uid(),
]);

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

// Initialize SQL conditions and parameters
$conditions = [];
$params = [
    'search_user' => '%' . strtolower($searchTerm) . '%',
    'search_action' => '%' . strtolower($searchTerm) . '%',
    'search_details' => '%' . strtolower($searchTerm) . '%',
];

// Apply date filter only if clearFilter was not clicked
if (!$clearFilter) {
    if ($startDate && $endDate) {
        $conditions[] = "n.date_added BETWEEN :startDate AND :endDate";
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "n.date_added <= :endDate";
        $params['endDate'] = $endDate;
    }
}

// Combine search conditions
$conditions[] = "(
    u.user_name LIKE :search_user OR
    n.title LIKE :search_action OR
    n.message LIKE :search_details
)";

// Build the final query with conditions
$whereClause = 'WHERE ' . implode(' AND ', $conditions);

$activitycount = $db->query("
SELECT 
    u.user_name,
    COUNT(n.user_id) AS total
FROM 
    notifications n
JOIN 
    users u ON n.user_id = u.user_id
GROUP BY 
    u.user_name
ORDER BY 
    total DESC;
$whereClause
", $params)->get();

$pagination['pages_total'] = ceil($activitycount[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];


$activitylogs = [];

$activitylogs = $db->paginate("
SELECT
    n.user_id,
    u.user_name AS user_name,
    n.viewed,
    n.title,
    n.message,
    n.date_added
FROM
    notifications n
JOIN
    users u ON n.user_id = u.user_id
$whereClause
ORDER BY
    n.date_added DESC
LIMIT :start,:end
", array_merge($params, [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
]))->get();

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

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(date_added)) AS earliest_year FROM notifications')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

view('logs/index.view.php', [
    'heading' => 'System Logs',
    'activitylogs' => $activitylogs,
    'pagination' => $pagination,
    'years' => $years,
    'notificationCount' => $notificationCount
]);