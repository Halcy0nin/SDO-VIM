<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {

    // Fetch the old values before updating
    $old_item = $db->query('SELECT * FROM school_inventory WHERE item_code = :id_to_update', [
        'id_to_update' => $_POST['id_to_update']
    ])->findOrFail();

    // Prepare and execute the update query
    $db->query("UPDATE school_inventory SET
        item_status = 1,
        item_inactive = item_inactive - :item_repair_count,
        item_active = item_active + :item_repair_count,
        updated_by = :updated_by
    WHERE item_code = :id_to_update;", [
        'updated_by' => $_SESSION['user']['user_id'] ?? 'Admin',
        'item_repair_count' => $_POST['item_repair_count'],
        'id_to_update' => $_POST['id_to_update'] ?? null
    ]);

    $db->query('UPDATE repair_requests SET
        is_active = 0
    WHERE id = :request_to_update;', [
        'request_to_update' => $_POST['request_to_update'] ?? null
    ]);

    toast('Successfully repaired item with item code: ' . $old_item['item_code']);

    redirect('/coordinator/resources/repair');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to repait the item. Please try again.');

    // Redirect back to the inventory page
    redirect('/coordinator/resources/repair');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the inventory page
    redirect('/coordinator/resources/repair');
}
