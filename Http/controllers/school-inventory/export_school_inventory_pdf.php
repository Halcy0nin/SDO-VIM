<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

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
        'id' => $_POST['id'] ?? null
    ])->get();

$html2pdf = new Html2Pdf('L', 'LEGAL', 'en', false, 'UTF-8', array(10, 10, 10, 10));

$date = date('m/d/Y h:i:s a', time());

// Start building the HTML content
$html = '
<page backtop="50mm" backbottom="30mm"> 
    <page_header> 
       <img src="../public/export-headers/sdo_header.png" style="width:60%;height:25%;" />             
    </page_header>
    <h1 style="margin:70; margin-top:0px;"> ' . ($items[0]['school_name'] ?? 'School') . ' Inventory Data </h1>
    <h4 style="margin: 0px; margin-top: -40px; margin-left: -40px;">Generated on: ' . $date . '</h4>
    <table class="table table-striped" style="width: 97%; word-wrap: break-word; overflow-wrap: break-word; border-collapse: collapse; margin: -15px; margin-top: 10px;">
        <thead>
            <tr>
                <th style="text-align: center; width: 14%; height: 7%; border: 2px solid black;">Item Code</th>
                <th style="text-align: center; width: 3%; border: 2px solid black;">Article</th>
                <th style="text-align: center; width: 7%; border: 2px solid black;">Description</th>
                <th style="text-align: center; width: 5%; border: 2px solid black;">Date Acquired</th>
                <th style="text-align: center; width: 5%; border: 2px solid black;">Status</th>
                <th style="text-align: center; width: 5%; border: 2px solid black;">Source of Funds</th>
                <th style="text-align: center; width: 10%; border: 2px solid black;">Unit Value</th>
                <th style="text-align: center; width: 7%; border: 2px solid black;">Qty</th>
                <th style="text-align: center; width: 10%; border: 2px solid black;">Total Value</th>
                <th style="text-align: center; width: 8%; border: 2px solid black;">Active</th>
                <th style="text-align: center; width: 8%; border: 2px solid black;">Inactive</th>
            </tr>
        </thead>
        <tbody>';

$statusMap = [
    1 => 'Working',
    2 => 'Need Repair',
    3 => 'Condemned'
];

// Loop through the items and add each row to the table
foreach ($items as $item) {
    $html .= '
        <tr>
            <td style="text-align: center;width: 5%; border: 2px solid black;">' . htmlspecialchars($item['item_code']) . '</td>
            <td style="text-align: center; width: 12%; border: 2px solid black;">' . htmlspecialchars($item['item_article']) . '</td>
            <td style="text-transform: capitalize; text-align: center; width: 3%; border: 2px solid black;">' . htmlspecialchars($item['item_desc']) . '</td>
            <td style="text-align: center; width: 9%; border: 2px solid black;">' . htmlspecialchars($item['date_acquired']) . '</td>
            <td style="text-align: center; width: 9%; border: 2px solid black;">' . htmlspecialchars($statusMap[$item['item_status']]) . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($item['item_funds_source']) . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($item['item_unit_value']) . '</td>
            <td style="text-align: center; width: 9%; border: 2px solid black;">' . htmlspecialchars($item['item_quantity']) . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($item['item_total_value']) . '</td>
            <td style="text-align: center; width: 6%; border: 2px solid black;">' . htmlspecialchars($item['item_active']) . '</td>
            <td style="text-align: center; width: 8%; border: 2px solid black;">' . htmlspecialchars($item['item_inactive']) . '</td>
        </tr>';
}

$html .= '
        </tbody>
    </table>
</page>';

// Create a dynamic filename
$filename = 'sdo_val_' . ($items[0]['school_name'] ?? 'school') . '_inventory_data_' . date('Y-m-d') . '.pdf';

// Set the filename and output the PDF
$html2pdf->writeHTML($html);
$html2pdf->output($filename);
?>
