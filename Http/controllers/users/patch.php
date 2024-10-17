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
use Http\Forms\UserEditForm;

$db = App::resolve(Database::class);

try {
    // Validate user input
    $form = UserEditForm::validate($attributes = [
        'user_id' => $_POST['id_to_update'],
        'user_name' => $_POST['user_name'],
        'school_id' => $_POST['school_id'] ?? '',
    ]);

    // Update user information in the database
    $db->query('UPDATE users
        SET
        user_name = :user_name,
        school_id = :school_id,
        date_modified = current_timestamp
        WHERE user_id = :id_to_update
    ',  [
        'user_name' => $_POST['user_name'],
        'school_id' => $_POST['school_id'] ?? null,
        'id_to_update' => $_POST['id_to_update'],
    ]);

    toast('Account Details changed successfully!');

    redirect('/coordinator/users');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to update user details. Please try again.');

    // Redirect back to the user edit form
    redirect('/coordinator/users/edit/' . $_POST['id_to_update']);

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the user edit form
    redirect('/coordinator/users/edit/' . $_POST['id_to_update']);
}
