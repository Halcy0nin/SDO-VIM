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
use Http\Forms\UserAddForm;

$db = App::resolve(Database::class);

$form = UserAddForm::validate($attributes = [
    'user_name' => $_POST['user_name'],
    'password' => $_POST['password'],
    'password_confirm' => $_POST['password_confirm'],
    'school_id' => $_POST['school_id'] ?? '',
    'user_role' => $_POST['user_role'],
]);

// Hash the password
$hashed_password = password_hash($attributes['password'], PASSWORD_DEFAULT);

$db->query('INSERT INTO users (
    user_name,
    role,
    password,
    school_id
) VALUES (
    :user_name,
    :role,
    :password,
    :school_id
)', [
    'user_name' => $_POST['user_name'],
    'role' => $_POST['user_role'],
    'password' => $hashed_password,
    'school_id' => $_POST['school_id'] ?? null,
]);

$messageUserName = $_POST['user_name'];

toast('Sucessfully Added User: ' . $messageUserName);

redirect('/coordinator/users');