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
        $conditions[] = "ir.request_date BETWEEN :startDate AND :endDate";
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "ir.request_date <= :endDate";
        $params['endDate'] = $endDate;
    }
}

// Combine search conditions
$conditions[] = "(
    ir.item_code LIKE :search_code OR
    ir.item_article LIKE :search_article OR
    ir.item_desc LIKE :search_desc
)";

// Build the final query with conditions
$whereClause = 'WHERE ' . implode(' AND ', $conditions);

// Count total item requests
$itemRequestsCountQuery = $db->query("
    SELECT COUNT(*) AS total
    FROM item_requests ir
    $whereClause
    AND ir.school_id = :id
", array_merge($params, [
    'id' => $_SESSION['user']['school_id'] ?? null
]))->find();

$pagination['pages_total'] = ceil($itemRequestsCountQuery['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

// Fetch item requests with pagination
$itemRequests = $db->paginate("
     SELECT 
        ir.id,
        ir.item_code,
        ir.item_request_status,
        ir.school_id,
        s.school_name,
        ir.request_date,
        ir.item_article,
        ir.item_desc,
        ir.item_quantity,
        ir.item_active,
        ir.item_inactive,
        ir.item_unit_value,
        ir.item_funds_source
    FROM item_requests ir
    JOIN schools s ON s.school_id = ir.school_id
    $whereClause
    AND ir.school_id = :id
    ORDER BY ir.request_date DESC
    LIMIT :start, :end;
", array_merge($params, [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
    'id' => $_SESSION['user']['school_id'] ?? null
]))->get();

$oldValues = $db->query('
    SELECT si.*
    FROM school_inventory si
    JOIN item_requests ir ON si.item_code = ir.item_code;
')->get();

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(request_date)) AS earliest_year FROM item_requests WHERE school_id = :id', ['id' => $_SESSION['user']['school_id'] ?? null])->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

$statusMap = [
    0 => 'Pending',
    1 => 'Approved',
    2 => 'Rejected'
];

// Render the view
view('custodian-resources/edit-requests/index.view.php', [
    'heading' => 'Edit Item Requests',
    'notificationCount' => $notificationCount,
    'years' => $years,
    'itemRequests' => $itemRequests,
    'oldValues' => $oldValues,
    'statusMap' => $statusMap,
    'pagination' => $pagination,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? []
]);
