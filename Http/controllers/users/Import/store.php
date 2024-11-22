<?php

use Core\Database;
use Core\App;
use PhpOffice\PhpSpreadsheet\IOFactory;

$db = App::resolve(Database::class);

// Check for upload errors
if ($_FILES['uploadedForm']['error'] > 0) {
    error_throw(['import_users' => ['uploadedForm' => 'Oh No! Something happened while uploading, please try again.']]);
}

$fileName = $_FILES['uploadedForm']['name'];
$file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

$allowed_ext = ['xls', 'csv', 'xlsx'];

if (in_array($file_ext, $allowed_ext)) {
    $inputFileNamePath = $_FILES['uploadedForm']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();
    } catch (\Exception $e) {
        error_throw(['import_users' => ['file' => 'Error reading file: ' . $e->getMessage()]]);
        toast('Failed to Added User');
    }

    $rowCount = 0;
    foreach ($data as $row) {
        if ($rowCount >= 8) { //Starting row on Excel 
            // Check if the row is empty
            if (array_filter($row)) {
                $school_id = !empty($row[0]) ? $row[0] : null;
                $user_name = !empty($row[1]) ? $row[1] : null;
                $password = !empty($row[2]) ? $row[2] : null;
                $role = !empty($row[3]) ? $row[3] : null;

                // Hash the password
                $hashed_password = password_hash($attributes['$password'], PASSWORD_DEFAULT);

                // Insert user data
                $db->query('INSERT INTO users (
                    user_name,
                    role,
                    password,
                    school_id
                ) VALUES (
                    :user_name,
                    :role,
                    :password,
                    :school_id
                )', [
                    'user_name' => $user_name,
                    'role' => roles_to_int($role),
                    'password' => $hashed_password,
                    'school_id' => intval($school_id),
                ]);

                $msg = true;
            }
        }
        $rowCount++;
    }
} else {
    error_throw(['import_users' => ['file' => 'Invalid file extension.']]);
}

redirect('/coordinator/users');
