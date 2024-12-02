<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

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

// Count total item requests
$itemRequestsCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM item_requests ir
')->find();

$pagination['pages_total'] = ceil($itemRequestsCountQuery['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

// Fetch item requests with pagination
$itemRequests = $db->paginate('
     SELECT 
        ir.id,
        ir.item_code,
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
    ORDER BY ir.request_date DESC
    LIMIT :start, :end;
', [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();

$oldValues = $db->query('
    SELECT si.*
    FROM school_inventory si
    JOIN item_requests ir ON si.item_code = ir.item_code;
')->get();

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(date_acquired)) AS earliest_year FROM school_inventory')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

// Render the view
view('resources/edit-requests/index.view.php', [
    'heading' => 'Resource Requests',
    'notificationCount' => $notificationCount,
    'years' => $years,
    'itemRequests' => $itemRequests,
    'oldValues' => $oldValues,
    'pagination' => $pagination,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? []
]);
