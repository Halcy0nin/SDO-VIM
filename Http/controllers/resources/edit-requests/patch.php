<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    $id = $_POST['id'];
    $item_code = $id . '-' . generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

    if (isset($_POST['approve_request'])) {

    // Insert request into `item_requests` table
    $db->query('UPDATE item_requests SET item_request_status = 1 WHERE id = :id;', [
        'id' => $_POST['request_to_update']
    ]);

    // Prepare and execute the update query for `school_inventory`
    $db->query('UPDATE school_inventory SET
        item_code = :item_code,
        item_article = :item_article,
        item_desc = :item_desc,
        item_unit_value = :item_unit_value,
        item_quantity = :item_quantity,
        item_funds_source = :item_funds_source,
        item_active = :item_active,
        item_inactive = :item_inactive,
        updated_by = :updated_by
    WHERE item_code = :id_to_update;', [
        'updated_by' => $_SESSION['user']['user_id'],
        'id_to_update' => $_POST['item_code'] ?? null,
        'item_code' => $item_code,
        'item_article' => $_POST['item_article'],
        'item_desc' => $_POST['item_desc'],
        'item_unit_value' => $_POST['item_unit_value'],
        'item_quantity' => $_POST['item_quantity'],
        'item_funds_source' => $_POST['item_funds_source'],
        'item_active' => $_POST['item_active'],
        'item_inactive' => $_POST['item_inactive']
    ]);
  
    } else {
        $db->query('UPDATE item_requests 
        SET item_request_status = 2
        WHERE id = :id;', [
        'id' => $_POST['request_to_update'],
        ]);
        // Show a success message
      toast('Successfully rejected item with code: ' . $item_code);
    }
    // Show a success message
    toast('Successfully updated item with code: ' . $item_code);

    // Redirect to the inventory page
    redirect('/coordinator/resources/edit-requests');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to update the item. Please try again.');

    // Redirect back to the inventory page
    redirect('/coordinator/resources/edit-requests');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the inventory page
    redirect('/coordinator/resources/edit-requests');
}
