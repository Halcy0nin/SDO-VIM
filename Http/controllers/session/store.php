<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

// Checking if Form Input are Valid

$form = LoginForm::validate($attributes = [
    'user_name' => $_POST['user_name'],
    'password' => $_POST['password'],
]);

// Attempt to Sign In

$signedIn = (new Authenticator)->attempt(
    $attributes['user_name'],
    $attributes['password']
);

if (!$signedIn) {
    // Function that throws an error message
    $form->error(
        'password',
        'No matching account found for that email address or password.'
    )->throw();
} elseif ($_SESSION['user']['role'] === 1) {
    redirect('/coordinator');
} elseif ($_SESSION['user']['role'] === 2) {
    redirect('/custodian');
}
