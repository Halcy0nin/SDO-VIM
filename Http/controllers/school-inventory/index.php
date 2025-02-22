<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

$items = [];

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

$resources_count = $db->query('
SELECT 
    COUNT(*) as total 
FROM 
    school_inventory
WHERE 
    school_id = :id
AND
    item_request_status = 1
AND 
    is_archived = 0
AND 
    item_assigned_status = 2;
', [
    'id' => $params['id'] ?? null
])->get();

$pagination['pages_total'] = max(1, ceil($resources_count[0]['total'] / $pagination['pages_limit']));
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$items = $db->paginate(
    '
    SELECT 
        si.item_code,
        si.item_article,
        si.item_desc,
        si.date_acquired,
        si.warranty_end,
        si.date_updated,
        si.item_unit_value,
        si.item_total_value,
        si.item_quantity,
        si.item_funds_source,
        si.item_status,
        si.item_active,
        si.item_inactive,
        si.school_id,
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
    WHERE 
        si.school_id = :id
    AND 
        si.is_archived = 0
    AND
        si.item_request_status = 1
    AND 
        si.item_assigned_status = 2
    LIMIT :start, :limit
    ',
    [
        'id' => $params['id'] ?? null,
        'start' => (int)$pagination['start'],
        'limit' => (int)$pagination['pages_limit'],
    ]
)->get();


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

$currentYear = date('Y');
$earliestYearQuery = $db->query('SELECT MIN(YEAR(date_acquired)) AS earliest_year FROM school_inventory')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? $currentYear;
$years = range($currentYear, $earliestYear);

view('school-inventory/index.view.php', [
    'id' => $params['id'] ?? null,
    'notificationCount' => $notificationCount,
    'years' => $years,
    'heading' => $schoolName,
    'items' => $items,
    'statusMap' => $statusMap,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'statusFilterValue' => $_POST['statusFilterValue'] ?? 'All',
    'pagination' => $pagination
]);
