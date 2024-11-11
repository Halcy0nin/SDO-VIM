<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    // Get the ID and prepare the new item code
    $id = $_POST['id'];
    $item_code = $_POST['school_id'] . '-' . $id;

    // Update the school inventory
    $db->query('UPDATE school_inventory 
                SET school_id = :school_id, 
                    item_code = :new_item_code
                WHERE item_code = :id', [
        'id' => $id, 
        'new_item_code' => $item_code,
        'school_id' => $_POST['school_id']
    ]);

    // Fetch the school name
    $school_name_query = $db->query('
        SELECT school_name
        FROM schools
        WHERE school_id = :school_id
    ', [
        'school_id' => $_POST['school_id']
    ]);

    // Get the school name or fallback to 'Unknown School'
    $school_name = $school_name_query->find();
    $school_destination = $school_name['school_name'] ?? 'Unknown School';

    // Show success toast message
    toast('Successfully allocated item ' . $_POST['id'] . ' to ' . $school_destination . '.');

    // Redirect to the unassigned resources page
    redirect('/coordinator/resources/unassigned');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to allocate the item. Please try again.');

    // Redirect back to the unassigned resources page
    redirect('/coordinator/resources/unassigned');
} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the unassigned resources page
    redirect('/coordinator/resources/unassigned');
}
