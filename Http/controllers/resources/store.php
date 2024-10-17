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
//   view variables are passed as keu-value
//   pairs as illustrated in the example above.
//

use Core\Database;
use Core\App;
use Http\Forms\ResourceAddForm;

$db = App::resolve(Database::class);

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

$user = $db->query('SELECT user_name FROM users WHERE user_id = :user_id', [
    'user_id' => get_uid()
])->findOrFail();

$message = $user['user_name'] . ' successfully added Unassigned Resource: ' . $_POST['item_quantity'] . ' new ' . $_POST['item_article'] . '.';

toast($message);

redirect('/coordinator/resources/unassigned');
