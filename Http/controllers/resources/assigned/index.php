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

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(item_assigned_date)) AS earliest_year FROM school_inventory')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);

if ($notificationCount > 5){
    $notificationCount = '5+';
};

$resources = [];

$resources = $db->query('
    SELECT 
    si.item_code,
    si.item_article,
    si.item_status AS status,
    si.date_acquired,
    si.item_assigned_date,
    s.school_name
FROM 
    school_inventory si
JOIN 
    schools s ON s.school_id = si.item_assigned_school
WHERE 
    si.item_assigned_status = 1;
')->get();

view('resources/assigned/index.view.php', [
    'heading' => 'Assigned Resources',
    'years' => $years,
    'notificationCount' => $notificationCount,
    'resources' => $resources,
]);
