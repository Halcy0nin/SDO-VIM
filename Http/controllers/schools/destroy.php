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

// Fetch the old school_id before deleting
$school = $db->query('SELECT school_id FROM schools WHERE school_id = :id_to_delete', [
    'id_to_delete' => $_POST['id_to_delete'],
])->findOrFail(); 


$db->query('DELETE from schools where school_id = :id_to_delete', [
    'id_to_delete' => $_POST['id_to_delete'],
]);

toast('Successfully deleted school with code: ' . $school['school_id']);

redirect('/coordinator/schools');