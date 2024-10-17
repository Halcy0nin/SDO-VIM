<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$items = [];

$items = $db->query('
    SELECT 
        si.item_code,
        si.item_article,
        si.item_desc,
        si.date_acquired,
        si.date_updated,
        si.item_unit_value,
        si.item_total_value,
        si.item_quantity,
        si.item_funds_source,
        si.item_status,
        si.item_active,
        si.item_inactive,
        s.school_name
    FROM school_inventory si
    JOIN schools s ON si.school_id = s.school_id
    WHERE si.school_id = :id',
    [
        'id' => $_SESSION['user']['school_id'] ?? null
    ])->get();

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
$sheet->setCellValue('A7', 'Item Code');
$sheet->setCellValue('B7', 'Article');
$sheet->setCellValue('C7', 'Description');
$sheet->setCellValue('D7', 'Date Acquired');
$sheet->setCellValue('E7', 'Status');
$sheet->setCellValue('F7', 'Source of Funds');
$sheet->setCellValue('G7', 'Unit Value');
$sheet->setCellValue('H7', 'Qty');
$sheet->setCellValue('I7', 'Total Value');
$sheet->setCellValue('J7', 'Active');
$sheet->setCellValue('K7', 'Inactive');

// Loop through the data and add it to the sheet
$row = 8; // Starting row (after the letterhead)

$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

foreach ($items as $item) {
    $sheet->setCellValue('A' . $row, $item['item_code']);
    $sheet->setCellValue('B' . $row, $item['item_article']);
    $sheet->setCellValue('C' . $row, $item['item_desc']);
    $sheet->setCellValue('D' . $row, $item['date_acquired']);
    $sheet->setCellValue('E' . $row, $statusMap[$item['item_status']]);
    $sheet->setCellValue('F' . $row, $item['item_funds_source']);
    $sheet->setCellValue('G' . $row, $item['item_unit_value']);
    $sheet->setCellValue('H' . $row, $item['item_quantity']);
    $sheet->setCellValue('I' . $row, $item['item_total_value']);
    $sheet->setCellValue('J' . $row, $item['item_active']);
    $sheet->setCellValue('K' . $row, $item['item_inactive']);
    $row++;
}

// Save the spreadsheet as an Excel file
$writer = new Xlsx($spreadsheet);
$filename = 'sdo_val_' . $item['school_name'] . '_inventory_data_' . date('Y-m-d') . '.xlsx';
$writer->save($filename);

// Output the file for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
?>
