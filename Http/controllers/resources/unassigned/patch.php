<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$id = $_POST['id'];
$item_code = $_POST['school_id'] . '-' . $id;

// Update the school inventory
$db->query('UPDATE school_inventory 
            SET school_id = :school_id, 
                item_code = :new_item_code
            WHERE item_code = :id', [
    'id' => $id, 
    'new_item_code' => $item_code,
    'school_id' => $_POST['school_id']
]);

$school_name_query = $db->query('
    SELECT school_name
    FROM schools
    WHERE school_id = :school_id
', [
    'school_id' => $_POST['school_id']
]);

$school_name = $school_name_query->find();

$school_destination = $school_name['school_name'] ?? 'Unknown School';

toast('Successfully allocated item ' . $_POST['id'] . ' to ' . $school_destination . '.');

redirect('/coordinator/resources/unassigned');
