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

$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($password === $confirm_password) {
    $db->query('UPDATE users
        SET
        password = :password
        WHERE user_id = :id_to_update
    ',  [
        'password' => $hashed_password,
        'id_to_update' => $_POST['id_to_update']
    ]);
} else {
    echo "Passwords do not match.";
}

$db->query('
    INSERT INTO notifications (
        user_id, 
        title, 
        message
    )
    VALUES (
    :user_id,
    :title,
    :message
    )
', [ 
    'user_id' => $_POST['id_to_update'],
    'title' => 'Password Reset',
    'message' => 'Your Password was successfully reset by a Coordinator. Please contact them for further details.'
]);

toast('Password Changed Successfully!');
redirect('/coordinator/users');
