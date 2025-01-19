<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

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

$resources = [];

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

$resources_count = $db->query('
    SELECT COUNT(*) AS total
    FROM add_item_requests ar
    WHERE ar.school_id = :id
', [
    'id' => $_SESSION['user']['school_id'] ?? null
])->get();


$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(request_date)) AS earliest_year FROM add_item_requests WHERE school_id = :id', [ 'id' => $_SESSION['user']['school_id'] ?? null])->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

$resources = $db->paginate('
SELECT 
        ar.id,
        ar.item_code,
        ar.school_id,
        ar.date_acquired,
        ar.warranty_end,
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
    WHERE ar.school_id = :id
    ORDER BY ar.request_date DESC
    LIMIT :start, :end;
', [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
    'id' => $_SESSION['user']['school_id'] ?? null
])->get();

$statusMap = [
    0 => 'Pending',
    1 => 'Approved',
    2 => 'Rejected',
    3 => 'Cancelled'
];

view('custodian-resources/requests/index.view.php', [
    'heading' => 'Add Item Requests',
    'notificationCount' => $notificationCount,
    'years' => $years,
    'statusMap' => $statusMap,
    'resources' => $resources,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination
]);
