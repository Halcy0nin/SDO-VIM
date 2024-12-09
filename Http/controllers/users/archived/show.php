<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

$roleFilterValue = $_POST['roleFilterValue'] ?? 'All';
$clearFilter = isset($_POST['clearFilter']);
$searchTerm = trim($_POST['search'] ?? '');

if ($clearFilter) {
    $roleFilterValue = 'All';
    $searchTerm = '';
}

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

// Initialize SQL conditions and parameters
$conditions = [];
$parameters = [
    'search_id' => '%' . strtolower($searchTerm) . '%',
    'search_school' => '%' . strtolower($searchTerm) . '%',
    'search_school' => '%' . strtolower($searchTerm) . '%',
    'search_uname' => '%' . strtolower($searchTerm) . '%',
    'search_contact' => '%' . strtolower($searchTerm) . '%',
    'search_no' => '%' . strtolower($searchTerm) . '%',
    'search_email' => '%' . strtolower($searchTerm) . '%'
];

// Apply filters
if ($roleFilterValue !== 'All') {
    $conditions[] = "u.role = :role";
    $parameters['role'] = $roleFilterValue;
}

$conditions[] = "(
    u.user_id LIKE :search_id OR
    s.school_name LIKE :search_school OR
    u.user_name LIKE :search_uname OR
    c.contact_name LIKE :search_contact OR
    c.contact_no LIKE :search_no OR
    c.contact_email LIKE :search_email
)";

$whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

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
        u.is_archived,
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
    $whereClause
    AND
        u.is_archived = 1
    LIMIT :start,:end
",  array_merge($parameters, [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit']
]))->get();

view('users/archived/index.view.php', [
    'heading' => 'Archived Users',
    'users' => $users,
    'notificationCount' => $notificationCount,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'roleFilterValue' => $_POST['roleFilterValue'] ?? 'All',
    'search' => $searchTerm
]);
