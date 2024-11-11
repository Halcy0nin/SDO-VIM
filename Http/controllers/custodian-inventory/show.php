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

$items_count = $db->query('
SELECT
    COUNT(*) as total
FROM
    school_inventory si
LEFT JOIN
    schools s ON s.school_id = si.school_id
WHERE
    si.school_id = :id AND
    (
        item_code LIKE :search_code OR
        item_article LIKE :search_article OR
        item_desc LIKE :search_desc OR
        item_funds_source LIKE :search_source OR
        item_status LIKE :search_status
    )
', [
    'id' => $_SESSION['user']['school_id'] ?? null,
    'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_source' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_status' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
])->get();


$pagination['pages_total'] = ceil($items_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$items = $db->paginate('
SELECT 
    item_code,
    item_article,
    item_desc,
    date_acquired,
    date_updated,
    item_unit_value,
    item_total_value,
    item_quantity,
    item_funds_source,
    item_status,
    item_active,
    item_inactive,
    item_status_reason
FROM 
    school_inventory si
LEFT JOIN 
    schools s ON s.school_id = si.school_id
WHERE
    si.school_id = :id AND
    (
        item_code LIKE :search_code OR
        item_article LIKE :search_article OR
        item_desc LIKE :search_desc OR
        item_status LIKE :search_status
    )
LIMIT :start,:end
', [
    'id' => $_SESSION['user']['school_id'] ?? null,
    'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_status' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();


$schoolName = $db->query('
    SELECT s.school_name 
    FROM schools s 
    WHERE s.school_id = :id',
    [
        'id' => $_SESSION['user']['school_id'] ?? null
    ])->find();

$schoolName = $schoolName['school_name'] ?? 'Unnamed School';

$histories = [];
$histories = $db->query('
SELECT h.action, h.modified_at, h.item_code, u.user_name
FROM school_inventory_history h
INNER JOIN users u ON h.user_id = u.user_id
INNER JOIN (
    SELECT item_code, MAX(modified_at) AS latest_update
    FROM school_inventory_history
    GROUP BY item_code
) latest ON h.item_code = latest.item_code AND h.modified_at = latest.latest_update;
')->get();

$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

view('custodian-inventory/show.view.php', [
    'id' => $_SESSION['user']['school_id'] ?? null,
    'histories' => $histories,
    'notificationCount' => $notificationCount,
    'heading' => $schoolName,
    'items' => $items,
    'statusMap' => $statusMap,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'search' => $_POST['search']
]);