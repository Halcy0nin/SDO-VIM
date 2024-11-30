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

// Validate date format
if ($startDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
    $startDate = null;
}
if ($endDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
    $endDate = null;
}

// Notification count query
$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND created_by != :user_id 
', [
    'user_id' => get_uid(),
])->find();

$notificationCount = $notificationCountQuery['total'];
if ($notificationCount > 5) {
    $notificationCount = '5+';
}

// Pagination setup
$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

// Initialize SQL conditions and parameters
$conditions = [];
$params = [
    'search_code' => '%' . strtolower($searchTerm) . '%',
    'search_article' => '%' . strtolower($searchTerm) . '%',
    'search_desc' => '%' . strtolower($searchTerm) . '%',
    'search_school' => '%' . strtolower($searchTerm) . '%',
];

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

// Build the final query with conditions
$whereClause = 'WHERE ' . implode(' AND ', $conditions);

// Count total resources
$totalResourcesQuery = $db->query("
    SELECT COUNT(*) as total 
    FROM school_inventory si
    LEFT JOIN schools s ON s.school_id = si.school_id
    $whereClause
", $params)->get();

$pagination['pages_total'] = ceil($totalResourcesQuery[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(date_acquired)) AS earliest_year FROM school_inventory')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

// Fetch resources with pagination
$resources = $db->paginate("
    SELECT 
        si.item_code,
        si.item_article,
        s.school_name,
        si.item_status AS status,
        si.date_acquired
    FROM 
        school_inventory si
    LEFT JOIN 
        schools s ON s.school_id = si.school_id
    $whereClause
    AND
    item_request_status = 1
    AND 
    item_assigned_status = 2
    AND 
    si.is_archived = 0
    LIMIT :start, :end
", array_merge($params, [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
]))->get();

// Map item statuses
$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

// Render view with the data
view('resources/index.view.php', [
    'notificationCount' => $notificationCount,
    'statusMap' => $statusMap,
    'years' => $years,
    'heading' => 'Resources',
    'resources' => $resources,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'startDate' => $_POST['yearFilter'] ?? '', // Keep original input for the view
    'endDate' => $_POST['yearFilter'] ?? '',
    'search' => $searchTerm
]);
