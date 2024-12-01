<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

try {
    $id = $_POST['id'];
    $item_code = $id . '-' . generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

    // Prepare and execute the update query for `school_inventory`
    $db->query('UPDATE school_inventory SET
        item_code = :item_code,
        item_article = :item_article,
        item_desc = :item_desc,
        date_acquired = :date_acquired,
        item_unit_value = :item_unit_value,
        item_quantity = :item_quantity,
        item_funds_source = :item_funds_source,
        item_active = :item_active,
        item_inactive = :item_inactive,
        item_status = :item_status,
        updated_by = :updated_by
    WHERE item_code = :id_to_update;', [
        'updated_by' => $_SESSION['user']['user_id'],
        'id_to_update' => $_POST['id_to_update'] ?? null,
        'item_code' => $item_code,
        'item_article' => $_POST['item_article'],
        'item_desc' => $_POST['item_desc'],
        'date_acquired' => $_POST['date_acquired'],
        'item_unit_value' => $_POST['item_unit_value'],
        'item_quantity' => $_POST['item_quantity'],
        'item_funds_source' => $_POST['item_funds_source'],
        'item_active' => $_POST['item_active'],
        'item_inactive' => $_POST['item_inactive'] + $_POST['item_repair_count'] + $_POST['item_condemned_count'],
        'item_status' => $_POST['item_status']
    ]);

    // Insert into `repair_requests` if item_status = 2 (needs repair)
    if ($_POST['item_status'] == 2) {
        $db->query('INSERT INTO repair_requests (
            item_code, 
            school_id, 
            request_date, 
            item_count,
            description
        ) VALUES (
            :item_code, 
            :school_id, 
            NOW(), 
            :item_repair_count,
            :description
        );', [
            'item_code' => $item_code,
            'school_id' => $_POST['school_id'],
            'description' => $_POST['item_status_reason'],
            'item_repair_count' => $_POST['item_repair_count'], // Use the reason as the repair description
        ]);
    }

    // Show a success message
    toast('Successfully updated item with code: ' . $item_code);

    // Redirect to the inventory page
    redirect('/custodian/custodian-inventory');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to update the item. Please try again.');

    // Redirect back to the inventory page
    redirect('/custodian/custodian-inventory');

} catch (Exception $e) {
    // Handle any other types of exceptions
    error_log($e->getMessage());

    // Show a general error toast message
    toast('An unexpected error occurred. Please try again later.');

    // Redirect back to the inventory page
    redirect('/custodian/custodian-inventory');
}
