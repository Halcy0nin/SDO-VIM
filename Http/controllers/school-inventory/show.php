<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);


// Get input values
$startDate = $_POST['yearFilter'] ?? null;
$endDate = $_POST['yearFilter'] ?? null;
$statusFilterValue = $_POST['statusFilterValue'] ?? 'All';
$clearFilter = isset($_POST['clearFilter']);
$searchTerm = trim($_POST['search'] ?? '');

if ($clearFilter) {
    $startDate = null;
    $endDate = null;
    $statusFilterValue = null;
    $searchTerm = '';
    $conditions = []; // Reset conditions
    $parameters = []; // Reset parameters
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
if ($notificationCount > 5) {
    $notificationCount = '5+';
}

$items = [];

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

// Initialize SQL conditions and parameters
$conditions = [];
$parameters = [
    'search_code' => '%' . strtolower($searchTerm) . '%',
    'search_article' => '%' . strtolower($searchTerm) . '%',
    'search_desc' => '%' . strtolower($searchTerm) . '%'
];


// Apply date filter only if clearFilter was not clicked
if (!$clearFilter) {
    if ($statusFilterValue !== 'All') {
        $conditions[] = "si.item_status = :status";
        $parameters['status'] = $statusFilterValue;
    }
    if ($startDate && $endDate) {
        $conditions[] = "si.date_acquired BETWEEN :startDate AND :endDate";
        $parameters['startDate'] = $startDate;
        $parameters['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "si.date_acquired <= :endDate";
        $parameters['endDate'] = $endDate;
    }
}

// Combine search conditions
$conditions[] = "(
    si.item_code LIKE :search_code OR
    si.item_article LIKE :search_article OR
    si.item_desc LIKE :search_desc
)";

// Build the final query with conditions
$whereClause = 'WHERE ' . implode(' AND ', $conditions);

$resources_count = $db->query("
    SELECT COUNT(*) as total 
    FROM school_inventory si
    LEFT JOIN schools s ON s.school_id = si.school_id
$whereClause
AND
    si.school_id = :id 
AND
    si.item_request_status = 1;
", array_merge($parameters, [
    'id' => $params['id'] ?? null
]))->get();

$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(date_acquired)) AS earliest_year FROM school_inventory')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

$items = $db->paginate(
    "
    SELECT 
        si.item_code,
        si.item_article,
        si.item_desc,
        si.date_acquired,
        si.date_updated,
        si.item_unit_value,
        si.item_total_value,
        si.item_quantity,
        si.item_funds_source,
        si.item_status,
        si.item_status_reason,
        si.item_active,
        si.item_inactive,
        h.action AS history_action,
        h.modified_at AS history_modified,
        u.user_name AS history_by
    FROM 
        school_inventory si
    LEFT JOIN (
     	SELECT h1.*
        FROM school_inventory_history h1
        WHERE h1.modified_at = (
        	SELECT MAX(h2.modified_at)
            FROM school_inventory_history h2
            WHERE h1.item_code = h2.item_code
            )
        ) h ON si.item_code = h.item_code
    INNER JOIN users u on h.user_id = u.user_id
    $whereClause
    AND 
        si.school_id = :id 
    AND 
        si.is_archived = 0;
    LIMIT :start,:end
    ",array_merge($parameters, [
        'start' => (int)$pagination['start'],
        'end' => (int)$pagination['pages_limit'],
        'id' => $params['id'] ?? null,
    ]))->get();

$schoolName = $db->query('
SELECT 
    s.school_name 
FROM 
    schools s 
WHERE 
    s.school_id = :id
', [
    'id' => $params['id'] ?? null
])->find();

$schoolName = $schoolName['school_name'] ?? 'Unnamed School';

$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

view('school-inventory/show.view.php', [
    'id' => $params['id'] ?? null,
    'heading' => $schoolName,
    'years' => $years,
    'notificationCount' => $notificationCount,
    'items' => $items,
    'statusMap' => $statusMap,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'startDate' => $_POST['yearFilter'] ?? '', // Keep original input for the view
    'endDate' => $_POST['yearFilter'] ?? '',
    'statusFilterValue' => $_POST['statusFilterValue'] ?? '',
    'search' => $searchTerm
]);
