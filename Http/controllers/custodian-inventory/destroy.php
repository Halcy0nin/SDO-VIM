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
//   view variables are passed as key-value
//   pairs as illustrated in the example above.
// 

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    // Attempt to delete the item from the inventory
    $db->query('UPDATE school_inventory SET is_archived = 1 where item_code = :id_to_delete', [
        'id_to_delete' => $_POST['id_to_delete'],
    ]);

    // Show a success message after deletion
    toast('Successfully archived item with code: ' . $_POST['id_to_delete']);

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to archive the item. Please try again.');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');
}

// Redirect back to the inventory page
redirect('/custodian/custodian-inventory');
