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
WHERE 
    si.item_status = 3;
')->get();


$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(request_date)) AS earliest_year FROM condemned_requests')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

$resources = $db->paginate('
SELECT 
    cr.id,
    cr.item_code,
    s.school_name,
    cr.request_date,
    cr.description,
    si.item_article,
    cr.item_count
FROM 
    condemned_requests cr
JOIN 
    schools s ON s.school_id = cr.school_id
JOIN 
    school_inventory si ON si.item_code = cr.item_code
WHERE
    cr.is_active = 1
LIMIT :start, :end
', [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();

view('resources/condemned/index.view.php', [
    'heading' => 'Condemned Resources',
    'years' => $years,
    'notificationCount' => $notificationCount,
    'resources' => $resources,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination
]);
