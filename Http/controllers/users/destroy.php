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
    // Delete the user from the database
    $db->query('DELETE FROM users WHERE user_id = :id_to_delete', [
        'id_to_delete' => $_POST['id_to_delete'],
    ]);

    // Show a success message
    toast('Account deletion done successfully!');

    // Redirect to the users list
    redirect('/coordinator/users');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to delete account. Please try again.');

    // Redirect back to the users list
    redirect('/coordinator/users');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the users list
    redirect('/coordinator/users');
}
