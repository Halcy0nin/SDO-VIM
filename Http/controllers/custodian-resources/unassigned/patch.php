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

$school_id = $_POST['school_id'];
$item_code = $school_id . '-' . $_POST['item_code'];

$db->query('UPDATE school_inventory 
            SET school_id = :school_id, 
                item_code = :new_item_code,
                updated_by = :updated_by
            WHERE item_code = :id;', [
    'id' => $_POST['item_code'] ?? null,
    'new_item_code' => $item_code,
    'school_id' => $school_id,
    'updated_by' => $_SESSION['user']['user_id'] ?? 'Admin'
]);



redirect('/custodian/custodian-resources/unassigned');