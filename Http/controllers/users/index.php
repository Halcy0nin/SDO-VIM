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

$users = [];

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

$resources_count = $db->query('SELECT COUNT(*) as total FROM users u')->get();
$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$users = $db->paginate("
    SELECT 
        u.user_id,
        u.school_id,
        u.user_name,
        u.date_added,
        u.date_modified,
        u.role as user_role,
        CASE
            WHEN u.role = 1 THEN 'Coordinator'
            WHEN u.role = 2 THEN 'Custodian'
        END as role,
        s.school_name AS school,
        c.contact_name,
        c.contact_no,
        c.contact_email
    FROM users u
    LEFT JOIN schools s ON u.school_id = s.school_id
    LEFT JOIN school_contacts c ON u.school_id = c.school_id
    LIMIT :start,:end
", [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();

view('users/index.view.php', [
    'heading' => 'Users',
    'notificationCount' => $notificationCount,
    'users' => $users,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination
]);
