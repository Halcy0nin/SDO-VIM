<?php

use Core\Database;
use Core\App;

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

$resources = [];

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
    school_inventory si
LEFT JOIN 
    schools s ON s.school_id = si.school_id 
WHERE
    si.school_id = :id AND
	(
        item_code LIKE :search_code OR
        item_article LIKE :search_article OR
        item_desc LIKE :search_desc OR
        s.school_name LIKE :search_school
    )
', [
    'id' => $_SESSION['user']['school_id'] ?? null,
    'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_school' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
])->get();

$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$resources = $db->paginate('
SELECT 
    si.item_code,
    si.item_article,
    s.school_name,
    si.item_status AS status,
    si.date_acquired
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
        s.school_name LIKE :search_school
    )
LIMIT :start,:end
', [
    'id' => $_SESSION['user']['school_id'] ?? null,
    'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_school' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();

$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

view('custodian-resources/show.view.php', [
    'statusMap' => $statusMap,
    'heading' => 'Resources',
    'notificationCount' => $notificationCount,
    'resources' => $resources,
    'pagination' => $pagination,
    'search' => $_POST['search']
]);
