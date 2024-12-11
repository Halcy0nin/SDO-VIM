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

// Fetch notification count for the current user
$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND created_by != :user_id
', [
    'user_id' => get_uid(),
])->find();

// Extract the total count
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
    'search_desc' => '%' . strtolower($searchTerm) . '%'
];

// Apply date filter only if clearFilter was not clicked
if (!$clearFilter) {
    if ($startDate && $endDate) {
        $conditions[] = "ar.request_date BETWEEN :startDate AND :endDate";
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "ar.request_date <= :endDate";
        $params['endDate'] = $endDate;
    }
}

// Combine search conditions
$conditions[] = "(
    ar.item_code LIKE :search_code OR
    ar.item_article LIKE :search_article OR
    ar.item_desc LIKE :search_desc
)";

// Build the final query with conditions
$whereClause = 'WHERE ' . implode(' AND ', $conditions);

// Count total item requests
$resourcesCountQuery = $db->query("
    SELECT COUNT(*) AS total
    FROM add_item_requests ar
    $whereClause
", $params)->find();

$pagination['pages_total'] = ceil($resourcesCountQuery['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

// Fetch item requests with pagination
$resources = $db->paginate("
     SELECT 
        ar.id,
        ar.item_code,
        ar.school_id,
        s.school_name,
        ar.request_date,
        ar.item_article,
        ar.item_desc,
        ar.item_quantity,
        ar.item_active,
        ar.item_inactive,
        ar.item_unit_value,
        ar.item_request_status,
        ar.item_funds_source
    FROM add_item_requests ar
    JOIN schools s ON s.school_id = ar.school_id
    $whereClause
    ORDER BY ar.request_date DESC
    LIMIT :start, :end;
", array_merge($params, [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
]))->get();

$oldValues = $db->query('
    SELECT si.*
    FROM school_inventory si
    JOIN add_item_requests ar ON si.item_code = ar.item_code;
')->get();

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(request_date)) AS earliest_year FROM add_item_requests')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

$statusMap = [
    0 => 'Pending',
    1 => 'Approved',
    2 => 'Rejected'
];

// Render the view
view('resources/requests/index.view.php', [
    'heading' => 'Add Item Requests',
    'notificationCount' => $notificationCount,
    'resources' => $resources,
    'statusMap' => $statusMap,
    'oldValues' => $oldValues,
    'pagination' => $pagination,
    'years' => $years,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? []
]);
