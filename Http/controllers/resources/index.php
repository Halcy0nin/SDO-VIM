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

$resources_count = $db->query('SELECT COUNT(*) as total FROM school_inventory')->get();
$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'date_acquired';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'ASC' : 'DESC'; // default to DESC

$sortableColumns = [
    'id' => 'si.item_code',
    'item_article' => 'si.item_article',
    'school' => 's.school_name',
    'status' => 'si.item_status',
    'date_acquired' => 'si.date_acquired'
];

if (!array_key_exists($sortColumn, $sortableColumns)) {
    $sortColumn = 'date_acquired';
}

$query = "
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
ORDER BY {$sortableColumns[$sortColumn]} $sortOrder
LIMIT :start, :end
";


$resources = $db->paginate($query, [
    'id' => $_SESSION['user']['school_id'] ?? null,
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();


$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

view('resources/index.view.php', [
    'notificationCount' => $notificationCount,
    'statusMap' => $statusMap,
    'heading' => 'Resources',
    'resources' => $resources,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination
]);
