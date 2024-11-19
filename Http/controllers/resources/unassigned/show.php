<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;
$clearFilter = isset($_POST['clearFilter']);
$searchTerm = trim($_POST['search'] ?? '');

// Notification count query
$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND created_by != :user_id 
', [
    'user_id' => get_uid(),
])->find();

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

// Initialize SQL conditions and parameters
$conditions = ["si.school_id IS NULL"];
$params = [
    'search_code' => '%' . strtolower($searchTerm) . '%',
    'search_article' => '%' . strtolower($searchTerm) . '%',
    'search_desc' => '%' . strtolower($searchTerm) . '%',
    'search_school' => '%' . strtolower($searchTerm) . '%',
];

// Apply date filter only if clearFilter was not clicked
if (!$clearFilter) {
    if ($startDate && $endDate) {
        $conditions[] = "si.date_acquired BETWEEN :startDate AND :endDate";
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "si.date_acquired <= :endDate";
        $params['endDate'] = $endDate;
    }
}

// Combine search conditions
$conditions[] = "(
    si.item_code LIKE :search_code OR
    si.item_article LIKE :search_article OR
    si.item_desc LIKE :search_desc OR
    s.school_name LIKE :search_school
)";

// Build the final query with conditions
$whereClause = 'WHERE ' . implode(' AND ', $conditions);

// Count total resources
$totalResourcesQuery = $db->query("
    SELECT COUNT(*) as total 
    FROM school_inventory si
    LEFT JOIN schools s ON s.school_id = si.school_id
    $whereClause
", $params)->get();

$pagination['pages_total'] = ceil($totalResourcesQuery[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

// Fetch resources with pagination
$resources = $db->paginate("
    SELECT 
        si.item_code,
        si.item_article,
        s.school_name,
        si.date_acquired
    FROM 
        school_inventory si
    LEFT JOIN 
        schools s ON s.school_id = si.school_id
    $whereClause
    AND 
    si.item_assigned_status = 0
    LIMIT :start, :end
", array_merge($params, [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
]))->get();

// Map item statuses
$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

$schoolDropdownContent = $db->query('
        SELECT school_name, school_id FROM schools;
') ->get();

// Render view with the data
view('resources/unassigned/show.view.php', [
    'notificationCount' => $notificationCount,
    'statusMap' => $statusMap,
    'heading' => 'Unassigned Resources',
    'resources' => $resources,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'startDate' => $startDate,
    'endDate' => $endDate,
    'schoolDropdownContent' => $schoolDropdownContent,
    'search' => $searchTerm
]);
