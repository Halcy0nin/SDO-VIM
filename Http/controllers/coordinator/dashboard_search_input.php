<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$schoolDropdownSearch = $db->query('
        SELECT school_name FROM schools
        WHERE
        school_name LIKE :search_school;
',[
    'search_school' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%'
]) ->get();

header('Content-Type: application/json');

echo json_encode($schoolDropdownSearch);
exit;

?>