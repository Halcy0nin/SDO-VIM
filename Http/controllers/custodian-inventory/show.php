<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

$schoolId = $_SESSION['user']['school_id'] ?? null;

$startDate = $_POST['yearFilter'] ?? null;
$endDate = $_POST['yearFilter'] ?? null;
$statusFilterValue = $_POST['statusFilterValue'] ?? 'All';
$searchTerm = trim($_POST['search'] ?? '');
$clearFilter = isset($_POST['clearFilter']);

// Clear filter logic
if ($clearFilter) {
    $startDate = null;
    $endDate = null;
    $statusFilterValue = 'All';
    $searchTerm = '';
}

// Handle year filter
if ($startDate && strlen($startDate) === 4) { // Year input
    $startDate = $startDate . '-01-01';
    $endDate = $endDate . '-12-31';
} elseif ($startDate || $endDate) {
    // Validate date input
    $startDate = $startDate ?: null;
    $endDate = $endDate ?: null;
}

// Initialize filters
$conditions = ["si.school_id = :id"]; // Always filter by school_id
$parameters = ['id' => $schoolId];   // Bind school_id

// Status filter
if ($statusFilterValue !== 'All') {
    $conditions[] = "item_status = :status";
    $parameters['status'] = $statusFilterValue;
}

// Date filter
if ($startDate && $endDate) {
    $conditions[] = "date_acquired BETWEEN :startDate AND :endDate";
    $parameters['startDate'] = $startDate;
    $parameters['endDate'] = $endDate;
} elseif ($endDate) {
    $conditions[] = "date_acquired <= :endDate";
    $parameters['endDate'] = $endDate;
}

// Search filter
if (!empty($searchTerm)) {
    $conditions[] = "(
        item_code LIKE :search_code OR
        item_article LIKE :search_article OR
        item_desc LIKE :search_desc
    )";
    $parameters['search_code'] = '%' . strtolower($searchTerm) . '%';
    $parameters['search_article'] = '%' . strtolower($searchTerm) . '%';
    $parameters['search_desc'] = '%' . strtolower($searchTerm) . '%';
}

// Build WHERE clause
$whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

// Pagination
$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

// Count total items
$items_count = $db->query("
    SELECT COUNT(*) as total
    FROM school_inventory si
    LEFT JOIN schools s ON s.school_id = si.school_id
    $whereClause
    AND item_request_status = 1
", $parameters)->find();

$pagination['pages_total'] = ceil(($items_count['total'] ?? 0) / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

// Fetch filtered items
$items = $db->paginate("
    SELECT 
        item_code,
        item_article,
        si.school_id,
        item_desc,
        date_acquired,
        date_updated,
        item_unit_value,
        item_total_value,
        item_quantity,
        item_funds_source,
        item_status,
        item_active,
        item_inactive
    FROM 
        school_inventory si
    LEFT JOIN 
        schools s ON s.school_id = si.school_id
    $whereClause
    AND item_request_status = 1
    AND si.item_assigned_status = 2
    AND si.is_archived = 0
    LIMIT :start, :limit
", array_merge($parameters, [
    'start' => (int) $pagination['start'],
    'limit' => (int) $pagination['pages_limit']
]))->get();

// Fetch school name
$schoolName = $db->query("
    SELECT s.school_name 
    FROM schools s 
    WHERE s.school_id = :id
", ['id' => $schoolId])->find();
$schoolName = $schoolName['school_name'] ?? 'Unnamed School';

// Fetch inventory history
$histories = $db->query("
    SELECT h.action, h.modified_at, h.item_code, u.user_name
    FROM school_inventory_history h
    INNER JOIN users u ON h.user_id = u.user_id
    INNER JOIN (
        SELECT item_code, MAX(modified_at) AS latest_update
        FROM school_inventory_history
        GROUP BY item_code
    ) latest ON h.item_code = latest.item_code AND h.modified_at = latest.latest_update
")->get();

// Status mapping
$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

// Fetch years for year filter
$currentYear = date('Y');
$earliestYearQuery = $db->query('SELECT MIN(YEAR(date_acquired)) AS earliest_year FROM school_inventory')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? $currentYear;
$years = range($currentYear, $earliestYear);

// Fetch notification count
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

// Render the view
view('custodian-inventory/show.view.php', [
    'id' => $schoolId,
    'histories' => $histories,
    'years' => $years,
    'notificationCount' => $notificationCount,
    'heading' => $schoolName,
    'items' => $items,
    'statusMap' => $statusMap,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'startDate' => $_POST['yearFilter'] ?? '',
    'endDate' => $_POST['yearFilter'] ?? '',
    'statusFilterValue' => $statusFilterValue,
    'search' => $searchTerm
]);
