<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    // Fetch the old item_code before deleting
    $item = $db->query('SELECT item_code FROM school_inventory WHERE item_code = :id_to_delete', [
        'id_to_delete' => $_POST['id_to_delete'],
    ])->findOrFail(); 

    // Perform the deletion
    $db->query('DELETE FROM school_inventory WHERE item_code = :id_to_delete', [
        'id_to_delete' => $_POST['id_to_delete'],
    ]);

    $id = $_POST['id'];

    toast('Successfully deleted item with code: ' . $item['item_code']);
    redirect('/coordinator/school-inventory/' . $id);

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to delete the item. Please try again.');

    // Redirect back to the inventory page
    redirect('/coordinator/school-inventory/' . $id);

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the inventory page
    redirect('/coordinator/school-inventory/' . $id);
}
