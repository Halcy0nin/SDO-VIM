<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    $id = $_POST['id'];
    $item_code = $id . '-' . generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

    if (isset($_POST['approve_request'])) {
    // Insert the new item into school inventory
    $db->query('INSERT INTO school_inventory (
        item_code, item_article, item_desc, date_acquired,
        item_unit_value, item_quantity, item_funds_source,
        item_active, item_inactive, school_id, updated_by, item_request_status, item_requested_by, item_assigned_status
    ) VALUES (
        :item_code, :item_article, :item_desc, :date_acquired,
        :item_unit_value, :item_quantity, :item_funds_source,
        :item_active, :item_inactive, :id, :updated_by, 1, :updated_by, 2
    );', [
        'updated_by' => $_SESSION['user']['user_id'],
        'id' => $id ?? null,
        'item_code' => $item_code,
        'item_article' => $_POST['item_article'],
        'item_desc' => $_POST['item_desc'],
        'date_acquired' => $_POST['date_acquired'],
        'item_unit_value' => $_POST['item_unit_value'],
        'item_quantity' => $_POST['item_quantity'],
        'item_funds_source' => $_POST['item_funds_source'],
        'item_active' => $_POST['item_active'],
        'item_inactive' => $_POST['item_inactive']
    ]);
    $db->query('UPDATE add_item_requests 
        SET item_request_status = 1
        WHERE id = :id;', [
        'id' => $_POST['request_to_update'],
        ]);
      // Show a success message
      toast('Successfully added item with code: ' . $item_code);
    }else{
        $db->query('UPDATE add_item_requests 
        SET item_request_status = 2
        WHERE id = :id;', [
        'id' => $_POST['request_to_update'],
        ]);
        // Show a success message
      toast('Successfully rejected item with code: ' . $item_code);
    }

    // Redirect to the specified resources page
    redirect('/coordinator/resources/requests');
    
} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to update the request status. Please try again.');

    // Redirect back to the resources page
    redirect('/coordinator/resources/requests');
} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the resources page
    redirect('/coordinator/resources/requests');
}
