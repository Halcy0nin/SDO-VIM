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

// Fetch the old item_code before deleting
$item = $db->query('SELECT item_code FROM school_inventory WHERE item_code = :id_to_delete', [
    'id_to_delete' => $_POST['id_to_delete'],
])->findOrFail(); 

$db->query('DELETE from school_inventory where item_code = :id_to_delete', [
    'id_to_delete' => $_POST['id_to_delete'],
]);

$id = $_POST['id'];

toast('Successfully deleted item with code: ' . $item['item_code']);

redirect('/coordinator/school-inventory/' . $id);