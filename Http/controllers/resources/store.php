<?php

use Core\Database;
use Core\App;
use Http\Forms\ResourceAddForm;

$db = App::resolve(Database::class);

// Validate the form inputs
$form = ResourceAddForm::validate($attributes = [
    'item_article' => $_POST['item_article'],
    'item_desc' => $_POST['item_desc'],
    'item_unit_value' => $_POST['item_unit_value'],
    'item_quantity' => $_POST['item_quantity'],
    'item_funds_source' => $_POST['item_funds_source'],
    'item_active' => $_POST['item_active'],
    'item_inactive' => $_POST['item_inactive']
]);

$item_code = generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

try {
    // Insert the new item into the database
    $db->query('INSERT INTO school_inventory (
        item_code, item_article, item_desc, date_acquired,
        item_unit_value, item_quantity, item_funds_source,
        item_active, item_inactive, updated_by
    ) VALUES (
        :item_code, :item_article, :item_desc, :date_acquired,
        :item_unit_value, :item_quantity, :item_funds_source,
        :item_active, :item_inactive, :updated_by
    );', [
        'updated_by' => $_SESSION['user']['user_id'],
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

    // Fetch the user's name for the message
    $user = $db->query('SELECT user_name FROM users WHERE user_id = :user_id', [
        'user_id' => get_uid()
    ])->findOrFail();

    // Create the success message
    $message = $user['user_name'] . ' successfully added Unassigned Resource: ' . $_POST['item_quantity'] . ' new ' . $_POST['item_article'] . '.';

    // Show success toast
    toast($message);

    // Redirect to the unassigned resources page
    redirect('/coordinator/resources/unassigned');

} catch (PDOException $e) {
    // Handle the database error gracefully
    error_log($e->getMessage());  // Log the error for debugging

    // Show an error toast message
    toast('Failed to add resource. Please try again.');

    // Redirect back to the previous page or the form
    redirect('/coordinator/resources/unassigned');
}
