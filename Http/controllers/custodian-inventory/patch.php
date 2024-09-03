<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$id = $_POST['id'];
$item_code = $id . '-' . generateSKU($_POST['item_article'], $_POST['item_desc'], $_POST['item_funds_source']);

// Prepare and execute the update query
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
WHERE school_id = :id;', [
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
    'item_inactive' => $_POST['item_inactive'],
    'item_status' => $_POST['item_status']
]);

redirect('/custodian/custodian-inventory');
