<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$schools = [];

$schools = $db->query('
    SELECT 
        s.school_id,
        s.school_name,
        s.type_id,
        t.school_type AS type,
        d.school_division AS division,
        di.school_district AS district,
        sc.contact_id,
        sc.contact_name,
        sc.contact_no,
        sc.contact_email,
        s.date_added
    FROM schools s
    JOIN types t ON s.type_id = t.id 
    JOIN divisions d ON s.division_id = d.id
    JOIN districts di ON s.district_id = di.id
    LEFT JOIN school_contacts sc ON s.school_id = sc.school_id;
')->get();

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
$sheet->setCellValue('A7', 'School ID');
$sheet->setCellValue('B7', 'School Name');
$sheet->setCellValue('C7', 'Type');
$sheet->setCellValue('D7', 'Division');
$sheet->setCellValue('E7', 'District');
$sheet->setCellValue('F7', 'Contact Name');
$sheet->setCellValue('G7', 'Contact Number');
$sheet->setCellValue('H7', 'Contact Email');
$sheet->setCellValue('I7', 'Date Added');

// Loop through the data and add it to the sheet
$row = 8; // Starting row (after the letterhead)
foreach ($schools as $school) {
    $sheet->setCellValue('A' . $row, $school['school_id']);
    $sheet->setCellValue('B' . $row, $school['school_name']);
    $sheet->setCellValue('C' . $row, $school['type']);
    $sheet->setCellValue('D' . $row, $school['division']);
    $sheet->setCellValue('E' . $row, $school['district']);
    $sheet->setCellValue('F' . $row, $school['contact_name']);
    $sheet->setCellValue('G' . $row, $school['contact_no']);
    $sheet->setCellValue('H' . $row, $school['contact_email']);
    $sheet->setCellValue('I' . $row, $school['date_added']);
    $row++;
}

// Save the spreadsheet as an Excel file
$writer = new Xlsx($spreadsheet);
$filename = 'export_with_letterhead.xlsx';
$writer->save($filename);

// Output the file for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
