<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$users = [];

$users = $db->query("
    SELECT 
        u.user_id,
        u.school_id,
        u.user_name,
        u.date_added,
        u.date_modified,
        u.role as user_role,
        CASE
            WHEN u.role = 1 THEN 'Coordinator'
            WHEN u.role = 2 THEN 'Custodian'
        END as role,
        s.school_name AS school,
        c.contact_name,
        c.contact_no,
        c.contact_email
    FROM users u
    LEFT JOIN schools s ON u.school_id = s.school_id
    LEFT JOIN school_contacts c ON u.school_id = c.school_id")->get();

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add the letterhead image to the top of the sheet
$letterhead = new Drawing();
$letterhead->setName('Letterhead');
$letterhead->setDescription('Company Letterhead');
$letterhead->setPath('../public/sdo_header.png'); 
$letterhead->setHeight(100); 
$letterhead->setCoordinates('A1');
$letterhead->setWorksheet($sheet);

// add some additional data below the letterhead
$sheet->setCellValue('A7', 'ID');
$sheet->setCellValue('B7', 'Username');
$sheet->setCellValue('C7', 'Role');
$sheet->setCellValue('D7', 'School');
$sheet->setCellValue('E7', 'Contact Name');
$sheet->setCellValue('F7', 'Mobile Number');
$sheet->setCellValue('G7', 'Email');
$sheet->setCellValue('H7', 'Date Added');
$sheet->setCellValue('I7', 'Date Modified');

// Loop through the data and add it to the sheet
$row = 8; // Starting row (after the letterhead)

foreach ($users as $user) {
    $sheet->setCellValue('A' . $row, $user['user_id']);
    $sheet->setCellValue('B' . $row, $user['user_name']);
    $sheet->setCellValue('C' . $row, $user['role']);
    $sheet->setCellValue('D' . $row, $user['school']);
    $sheet->setCellValue('E' . $row, $user['contact_name']);
    $sheet->setCellValue('F' . $row, $user['contact_no']);
    $sheet->setCellValue('G' . $row, $user['contact_email']);
    $sheet->setCellValue('H' . $row, $user['date_added']);
    $sheet->setCellValue('I' . $row, $user['date_modified']);
    $row++;
}

// Save the spreadsheet as an Excel file
$writer = new Xlsx($spreadsheet);
$filename = 'sdo_val_users_data_' . date('Y-m-d') . '.xlsx';
$writer->save($filename);

// Output the file for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
