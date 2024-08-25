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
$db->query('INSERT INTO users (
    user_name,
    role,
    password
) VALUES (
    :user_name,
    :role,
    :password
)', [
    'user_name' => $_POST['user_name'],
    'role' => $_POST['school_type'],
    'password' => $hashed_password,
]);
} else {
    //put error handling for verification failure
    echo "Passwords do not match.";
}

redirect('/coordinator/users');