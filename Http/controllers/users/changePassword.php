<?php

// ==========================================
//           This is the Controller 
// ===========================================
//
//  This is where you load the corresponding
//  view file for this route if available.
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

$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$user_id = $_POST['id_to_update'];

$current_password = $db->query('SELECT password FROM users WHERE user_id = :user_id', [
    'user_id' => $user_id
])->find();

if (password_verify($password, $current_password['password'])) {
    toast ('You cannot reuse your old password.');
    redirect('/coordinator/users');
}
// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if ($password === $confirm_password) {
    
    $db->query('UPDATE users
        SET password = :password
        WHERE user_id = :user_id', [
        'password' => $hashed_password,
        'user_id' => $user_id
    ]);


    $db->query('
        INSERT INTO notifications (
            user_id, 
            title, 
            message
        ) VALUES (
            :user_id,
            :title,
            :message
        )', [
        'user_id' => $user_id,
        'title' => 'Password Reset',
        'message' => 'Your password was successfully reset by a Coordinator. Please contact them for further details.'
    ]);

    toast('Password Changed Successfully!');
    redirect('/coordinator/users');
} 

else {
    toast('Passwords does not match');
    redirect('/coordinator/users');
}
