<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    // Fetch the old school_id before deleting
    $school = $db->query('SELECT school_id FROM schools WHERE school_id = :school_id', [
        'school_id' => $_POST['school_id'],
    ])->findOrFail(); 

    // Archive the school
    $db->query('UPDATE schools SET is_archived = 0 WHERE school_id = :school_id', [
        'school_id' => $_POST['school_id'],
    ]);

    // Archive all items in the school_inventory table with the matching school_id
    $db->query('UPDATE school_inventory SET is_archived = 0 WHERE school_id = :school_id', [
        'school_id' => $_POST['school_id']
    ]);

    // Show success message
    toast('Successfully unarchived school with code: ' . $school['school_id'] . ' and its associated inventory items.');

    // Redirect to the schools list
    redirect('/coordinator/schools/archived');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to unarchive the school. Please try again.');

    // Redirect back to the schools list
    redirect('/coordinator/schools/archived');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the schools list
    redirect('/coordinator/schools/archived');
}
