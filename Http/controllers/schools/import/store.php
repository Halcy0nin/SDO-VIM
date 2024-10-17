<?php

use Core\Database;
use Core\App;
use PhpOffice\PhpSpreadsheet\IOFactory;

$db = App::resolve(Database::class);

// Check for upload errors
if ($_FILES['uploadedForm']['error'] > 0) {
    error_throw(['import_school' => ['uploadedForm' => 'Oh No! Something happened while uploading, please try again.']]);
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
        error_throw(['import_school' => ['file' => 'Error reading file: ' . $e->getMessage()]]);
    }

    $rowCount = 0;
    foreach ($data as $row) {
        if ($rowCount >= 8) { //Starting row on Excel 
            // Check if the row is empty
            if (array_filter($row)) {
                $school_id = !empty($row[0]) ? $row[0] : null;
                $school_name = !empty($row[1]) ? $row[1] : null;
                $type = !empty($row[2]) ? $row[2] : null;
                $division = !empty($row[3]) ? $row[3] : null;
                $district = !empty($row[4]) ? $row[4] : null;
                $contact_name = !empty($row[5]) ? $row[5] : null;
                $contact_number = !empty($row[6]) ? $row[6] : null;
                $contact_email = !empty($row[7]) ? $row[7] : null;

                // Insert school data
                $db->query('INSERT INTO schools ( 
                    school_id,
                    school_name,
                    type_id,
                    division_id,
                    district_id
                ) VALUES (
                    :school_id,
                    :school_name,
                    (SELECT id FROM types WHERE school_type = :school_type),
                    (SELECT id FROM divisions WHERE school_division = :school_division),
                    (SELECT id FROM districts WHERE school_district = :school_district)
                )', [
                    'school_id' => intval($school_id),
                    'school_name' => $school_name,
                    'school_type' => $type,
                    'school_division' => $division,
                    'school_district' => $district,
                ]);

                // Insert contact data
                $db->query('INSERT INTO school_contacts ( 
                    contact_name,
                    school_id,
                    contact_no,
                    contact_email
                ) VALUES (
                    :contact_name,
                    :school_id,
                    :contact_no,
                    :contact_email
                )', [
                    'contact_name' => $contact_name,
                    'school_id' => intval($school_id),
                    'contact_no' => $contact_number,
                    'contact_email' => $contact_email,
                ]);

                $msg = true;
            }
        }
        $rowCount++;
    }
} else {
    error_throw(['import_school' => ['file' => 'Invalid file extension.']]);
}

redirect('/coordinator/schools');
