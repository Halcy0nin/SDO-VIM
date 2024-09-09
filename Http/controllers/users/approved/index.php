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

$requests = [];

$requests = $db->query("
    SELECT 
    u.user_name,
    r.user_status,
    r.request_id,
    r.new_username,
    s.school_name,
    r.date_requested
FROM 
    users u
JOIN 
    schools s ON u.school_id = s.school_id
JOIN 
    user_requests r ON u.user_id = r.user_id
WHERE 
    r.user_status = 2;
")->get();

view('users/approved/index.view.php', [
    'heading' => 'Approved Requests',
    'requests' => $requests
]);
