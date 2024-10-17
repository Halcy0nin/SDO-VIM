<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

if ($_FILES['receipt']['error'] > 0) {
    error_throw(['add_receipt' => ['receipt' => 'Oh No! Something happenned while uploading, please try again.']]);
}

$filename = base_path("uploads/receipts/receipt_" . $_POST['id'] . "_" .  (new \DateTime())->format('mdYgi'));

$db_filename = "uploads/receipts/receipt_" . $_POST['id'] . "_" .  (new \DateTime())->format('mdYgi');

if (move_uploaded_file($_FILES['receipt']['tmp_name'], $filename)) {
    $db->query('
    INSERT INTO receipts(
    user_id, 
    school_id, 
    receipt
    ) 
    VALUES(
    :id,
    (SELECT school_id FROM users WHERE user_id = :id), 
    :receipt
    )', [
        'id' => $_POST['id'],
        'receipt' => $db_filename,
    ]);
} else {
    error_throw(['add_receipt' => ['receipt' => 'Oh No! Something happenned while uploading.']]);
}

redirect('/custodian');
