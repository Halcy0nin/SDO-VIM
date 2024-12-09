<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {

    // Archive all items in the school_inventory table with the matching school_id
    $db->query('UPDATE users SET is_archived = 0 WHERE user_id = :user_id', [
        'user_id' => $_POST['user_id']
    ]);

    // Show success message
    toast('Successfully unarchived user with ID: ' . $school['user_id']);

    // Redirect to the schools list
    redirect('/coordinator/users/archived');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to unarchive the school. Please try again.');

    // Redirect back to the schools list
    redirect('/coordinator/users/archived');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the schools list
    redirect('/coordinator/users/archived');
}
