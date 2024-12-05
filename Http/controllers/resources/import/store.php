<?php

use Core\Database;
use Core\App;
use PhpOffice\PhpSpreadsheet\IOFactory;

$db = App::resolve(Database::class);

// Check for upload errors
if ($_FILES['uploadedForm']['error'] > 0) {
    error_throw(['import_resources' => ['uploadedForm' => 'Oh No! Something happened while uploading, please try again.']]);
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
        error_throw(['import_resources' => ['file' => 'Error reading file: ' . $e->getMessage()]]);
    }

    $rowCount = 0;
    foreach ($data as $row) {
        if ($rowCount >= 8) { //Starting row on Excel 
            // Check if the row is empty
            if (array_filter($row)) {
                $item_article = !empty($row[0]) ? $row[0] : null;
                $item_desc = !empty($row[1]) ? $row[1] : null;
                $item_unit_value = !empty($row[2]) ? $row[2] : null;
                $item_quantity = !empty($row[3]) ? $row[3] : null;
                $item_active = !empty($row[4]) ? $row[4] : null;
                $item_inactive = !empty($row[5]) ? $row[5] : 0;
                $date_acquired = !empty($row[6]) ? $row[6] : null;
                $item_funds_source = !empty($row[7]) ? $row[7] : null;

                $item_code = generateSKU($item_article, $item_desc, $item_funds_source);

                // Insert school data
                $db->query('INSERT INTO school_inventory (
                    item_code, item_article, item_desc, date_acquired,
                    item_unit_value, item_quantity, item_funds_source,
                    item_active, item_inactive, updated_by, item_assigned_status
                ) VALUES (
                    :item_code, :item_article, :item_desc, :date_acquired,
                    :item_unit_value, :item_quantity, :item_funds_source,
                    :item_active, :item_inactive, :updated_by, 0
                );', [
                    'updated_by' => $_SESSION['user']['user_id'],
                    'item_code' => $item_code,
                    'item_article' => $item_article,
                    'item_desc' => $item_desc,
                    'date_acquired' => $date_acquired,
                    'item_unit_value' => $item_unit_value,
                    'item_quantity' => $item_quantity,
                    'item_funds_source' => $item_funds_source,
                    'item_active' => $item_active,
                    'item_inactive' => $item_inactive
                ]);

                $msg = true;
            }
        }
        $rowCount++;
    }
} else {
    error_throw(['import_resources' => ['file' => 'Invalid file extension.']]);
}

redirect('/coordinator/resources/unassigned');
