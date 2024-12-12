<?php

//  ==========================================
//           This is the Controller 
// ===========================================
// 
//  This is where you load the corresponding
//  view file for this route if available
// 
//   Use the view() function and feed the 
//   full path of the view.
// 
//   Being the controller file. This is where 
//   the data is get, manipulated, and/or
//   saved.
//      
//   You can pass variables to your view as the
//   second parameter of the view function.
//      
//   view('notes/{id}', ['notes' => $notes])
//
//   view variables are passed as keu-value
//   pairs as illustrated in the example above.
//

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

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(item_assigned_date)) AS earliest_year FROM school_inventory')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

if ($notificationCount > 5){
    $notificationCount = '5+';
};


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
        $conditions[] = "si.item_assigned_date BETWEEN :startDate AND :endDate";
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "si.item_assigned_date <= :endDate";
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

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

$resources_count = $db->query("
SELECT 
    COUNT(*) as total 
FROM 
    school_inventory si
LEFT JOIN 
    schools s ON s.school_id = si.school_id 
    $whereClause
    AND 
    si.item_assigned_status = 1
", $params)->get();

$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];


$resources = [];

$resources = $db->paginate("
    SELECT 
    si.item_code,
    si.item_article,
    si.item_status AS status,
    si.date_acquired,
    si.item_assigned_date,
    s.school_name
FROM 
    school_inventory si
JOIN 
    schools s ON s.school_id = si.item_assigned_school
$whereClause 
AND 
    si.item_assigned_status = 1;
", $params)->get();

view('resources/assigned/index.view.php', [
    'heading' => 'Assigned Resources',
    'years' => $years,
    'pagination' => $pagination,
    'notificationCount' => $notificationCount,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'resources' => $resources,
    'startDate' => $_POST['yearFilter'] ?? '', // Keep original input for the view
    'endDate' => $_POST['yearFilter'] ?? '',
    'search' => $searchTerm
]);
