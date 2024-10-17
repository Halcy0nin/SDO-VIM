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

$db = App::resolve(Database::class);

$id = $_POST['id'];
$item_code = $id . '-' . generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

$db->query('INSERT INTO school_inventory (
    item_code, item_article, item_desc, date_acquired,
    item_unit_value, item_quantity, item_funds_source,
    item_active, item_inactive, school_id, updated_by
) VALUES (
    :item_code, :item_article, :item_desc, :date_acquired,
    :item_unit_value, :item_quantity, :item_funds_source,
    :item_active, :item_inactive, :id, :updated_by
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

redirect('/custodian/custodian-inventory');