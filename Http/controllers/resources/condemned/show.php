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
SELECT 
    COUNT(*) as total 
FROM 
    school_inventory si
LEFT JOIN 
    schools s ON s.school_id = si.school_id 
WHERE 
    si.item_status = 3 AND
    (
        item_code LIKE :search_code OR
        item_article LIKE :search_article OR
        item_desc LIKE :search_desc OR
        s.school_name LIKE :search_school
    )
', [
    'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_school' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
])->get();

$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

if ($resources_count[0]['total'] !== 0) {
    $resources = $db->paginate('
    SELECT 
        si.item_code,
        si.item_article,
        s.school_name,
        si.item_status AS status,
        si.item_status_reason,
        si.item_inactive,
        si.date_acquired
    FROM 
        school_inventory si
    JOIN 
        schools s ON s.school_id = si.school_id
    WHERE 
        si.item_status = 3 AND
        (
            item_code LIKE :search_code OR
            item_article LIKE :search_article OR
            item_desc LIKE :search_desc OR
            s.school_name LIKE :search_school
        )
    LIMIT :start,:end
    ', [
        'search_code' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
        'search_article' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
        'search_desc' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
        'search_school' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
        'start' => (int)$pagination['start'],
        'end' => (int)$pagination['pages_limit'],
    ])->get();
}

view('resources/condemned/show.view.php', [
    'notificationCount' => $notificationCount,
    'heading' => 'Condemned Resources',
    'resources' => $resources,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'search' => $_POST['search']
]);
