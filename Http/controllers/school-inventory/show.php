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
    school_id = :id AND
   (
        item_code LIKE :search_code OR
        item_article LIKE :search_article OR
        item_desc LIKE :search_desc
    )
AND
    item_request_status = 1;
', [
    'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'id' => $params['id'] ?? null
])->get();

$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$items = $db->paginate(
    '
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
    WHERE 
        si.school_id = :id AND
        (
            si.item_code LIKE :search_code OR
            si.item_article LIKE :search_article OR
            si.item_desc LIKE :search_desc
        )
    AND 
        si.is_archived = 0;
    LIMIT :start,:end
    ',
    [
        'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
        'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
        'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
        'id' => $params['id'] ?? null,
        'start' => (int)$pagination['start'],
        'end' => (int)$pagination['pages_limit'],
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

view('school-inventory/show.view.php', [
    'id' => $params['id'] ?? null,
    'heading' => $schoolName,
    'notificationCount' => $notificationCount,
    'items' => $items,
    'statusMap' => $statusMap,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination
]);
