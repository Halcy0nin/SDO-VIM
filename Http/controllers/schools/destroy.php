<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    // Fetch the old school_id before deleting
    $school = $db->query('SELECT school_id FROM schools WHERE school_id = :id_to_delete', [
        'id_to_delete' => $_POST['id_to_delete'],
    ])->findOrFail(); 

    // Perform the deletion
    $db->query('DELETE from schools WHERE school_id = :id_to_delete', [
        'id_to_delete' => $_POST['id_to_delete'],
    ]);

    // Show success message
    toast('Successfully deleted school with code: ' . $school['school_id']);

    // Redirect to the schools list
    redirect('/coordinator/schools');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to delete the school. Please try again.');

    // Redirect back to the schools list
    redirect('/coordinator/schools');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the schools list
    redirect('/coordinator/schools');
}
