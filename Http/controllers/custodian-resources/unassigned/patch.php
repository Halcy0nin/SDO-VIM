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
    $school_id = $_POST['school_id'];
    $item_code = $school_id . '-' . $_POST['item_code'];

    // Update the school inventory
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

    // Show a success message
    toast('Successfully updated item code: ' . $item_code);

    // Redirect to the specified resources page
    redirect('/custodian/custodian-resources/unassigned');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to assign the item. Please try again.');

    // Redirect back to the resources page
    redirect('/custodian/custodian-resources/unassigned');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the resources page
    redirect('/custodian/custodian-resources/unassigned');
}
