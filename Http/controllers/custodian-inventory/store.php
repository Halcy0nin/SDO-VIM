<?php

//  ==========================================
//           This is the Controller 
// ===========================================
// 
//  This is where you load the corresponding
//  view file for this route if available
// 
//   Use the view() function and feed the 
//   full path of the view.
// 
//   Being the controller file. This is where 
//   the data is get, manipulated, and/or
//   saved.
//      
//   You can pass variables to your view as the
//   second parameter of the view function.
//      
//   view('notes/{id}', ['notes' => $notes])
//
//   view variables are passed as key-value
//   pairs as illustrated in the example above.
// 

use Core\Database;
use Core\App;
use Http\Forms\SchoolItemsAddForm;


$db = App::resolve(Database::class);

$form = SchoolItemsAddForm::validate($attributes = [
    'item_article' => $_POST['item_article'],
    'item_desc' => $_POST['item_desc'],
    'item_unit_value' => $_POST['item_unit_value'],
    'item_quantity' => $_POST['item_quantity'],
    'item_funds_source' => $_POST['item_funds_source'],
    'item_active' => $_POST['item_active'],
    'item_inactive' => $_POST['item_inactive']
]);

try {
    $id = $_POST['id'];
    $item_code = $id . '-' . generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

    // Insert the new item into school inventory
    $db->query('INSERT INTO add_item_requests (
        item_code, item_article, item_desc, date_acquired,
        item_unit_value, item_quantity, item_funds_source,
        item_active, item_inactive, school_id
    ) VALUES (
        :item_code, :item_article, :item_desc, :date_acquired,
        :item_unit_value, :item_quantity, :item_funds_source,
        :item_active, :item_inactive, :id
    );', [
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

    // Show a success message
    toast('Successfully added item with item code: ' . $item_code);

    redirect('/custodian/custodian-inventory');
} catch (PDOException $e) {
    // Handle database errors gracefully
    // Log the error for debugging purposes
    error_log($e->getMessage());

    // Show a toast message for the user
    toast('Failed to add item. Please try again.');

    // Optionally, redirect the user back to the form
    redirect('/custodian/custodian-inventory');
}
