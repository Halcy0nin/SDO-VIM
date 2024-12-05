<?php
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$id = $_POST['id'];
$item_code = $id . '-' . generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

try {
    $db->query('INSERT INTO school_inventory (
        item_code, item_article, item_desc, date_acquired,
        item_unit_value, item_quantity, item_funds_source,
        item_active, item_inactive, school_id, updated_by, item_request_status, item_assigned_status
    ) VALUES (
        :item_code, :item_article, :item_desc, :date_acquired,
        :item_unit_value, :item_quantity, :item_funds_source,
        :item_active, :item_inactive, :id, :updated_by, 1, 2
    );', [
        'updated_by' => $_SESSION['user']['user_id'],
        'id' => $_POST['id'] ?? null,
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

    // If the query is successful
    toast('Successfully added item with item code: ' . $item_code);

    redirect('/coordinator/school-inventory/' . $id);

} catch (PDOException $e) {
    // Handle database errors gracefully
    // Log the error for debugging purposes
    error_log($e->getMessage());

    // Show a toast message for the user
    toast('Failed to add item. Please try again.');

    // Optionally, redirect the user back to the form
    redirect('/coordinator/school-inventory/' . $id);
}
