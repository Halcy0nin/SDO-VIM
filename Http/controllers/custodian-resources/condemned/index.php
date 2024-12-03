<?php

//  ==========================================
//           This is the Controller 
// ===========================================
// 
//  This is where you load the corresponding
//  view file for this route if available
// 
//   Use the view() function and feed the 
//   full path of the view.
// 
//   Being the controller file. This is where 
//   the data is get, manipulated, and/or
//   saved.
//      
//   You can pass variables to your view as the
//   second parameter of the view function.
//      
//   view('notes/{id}', ['notes' => $notes])
//
//   view variables are passed as keu-value
//   pairs as illustrated in the example above.
//

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE
        viewed IS NULL
    AND (
        (user_id = :user_id AND (created_by != :user_id OR created_by IS NULL))
        OR is_public = 1
    );
',[
    'user_id' => get_uid()
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
    si.item_status = 3
AND
    si.school_id = :id 
AND
    si.item_request_status = 1
AND 
    si.item_assigned_status = 2
AND 
    si.is_archived = 0;
',[
    'id' => $_SESSION['user']['school_id'] ?? null
])->get();


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
AND
    si.school_id = :id 
LIMIT :start, :end
', [
    'id' => $_SESSION['user']['school_id'] ?? null,
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();

view('custodian-resources/condemned/index.view.php', [
    'heading' => 'Condemned Resources',
    'years' => $years,
    'notificationCount' => $notificationCount,
    'resources' => $resources,
    'pagination' => $pagination
]);
