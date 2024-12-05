<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

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

$html2pdf = new Html2Pdf('L', 'LEGAL', 'en', false, 'UTF-8', array(10, 10, 10, 10));

$date = date('m/d/Y h:i:s a', time());

$html = '
<page backtop="50mm" backbottom="30mm"> 
    <page_header> 
       <img src="../public/export-headers/sdo_header.png" style="width:60%;height:25%;" />             
    </page_header>
<h1 style="margin:70; margin-top:0px;" >Schools Data</h1>
<h4 style="margin:-40;">Generated on: ' . $date . '</h4>'; 

$html .= '
<table class="table table-striped" style="width: 100%; word-wrap: break-word; overflow-wrap: break-word; border-collapse: collapse; margin-left:2rem; margin-top: 2rem;">
    <thead>
        <tr>
            <th style="text-align: center; width: 0%; height: 7%; border: 2px solid black;">ID</th>
            <th style="text-align: center; width: 15%; border: 2px solid black;">Name</th>
            <th style="text-align: center; width: 10%; border: 2px solid black;">Type</th>
            <th style="text-align: center; width: 10%; border: 2px solid black;">Division</th>
            <th style="text-align: center; width: 10%; border: 2px solid black;">District</th>
            <th style="text-align: center; width: 10%; border: 2px solid black;">Contact Name</th>
            <th style="text-align: center; width: 10%; border: 2px solid black;">Contact Number</th>
            <th style="text-align: center; width: 10%; border: 2px solid black;">Contact Email</th>
            <th style="text-align: center; width: 10%; border: 2px solid black;">Date Added</th>
        </tr>
    </thead>
    <tbody>';
    
// Loop through the $schools array and add rows to the table
foreach ($schools as $school) {
    $html .= '
        <tr>
            <td style="text-align: center;width: 5%; border: 2px solid black;">' . htmlspecialchars($school['school_id']) . '</td>
            <td style="text-align: center; width: 15%; border: 2px solid black;">' . htmlspecialchars($school['school_name']) . '</td>
            <td style="text-transform: capitalize; text-align: center; width: 0%; border: 2px solid black;">' . htmlspecialchars($school['type']) . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($school['division']) . '</td>
            <td style="text-align: center; width: 11%; border: 2px solid black;">' . htmlspecialchars($school['district']) . '</td>
            <td style="text-align: center; width: 12%; border: 2px solid black;">' . htmlspecialchars($school['contact_name']) . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($school['contact_no']) . '</td>
            <td style="text-align: center; width: 18%; border: 2px solid black;">' . htmlspecialchars($school['contact_email']) . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars(formatTimestamp($school['date_added'])) . '</td>
        </tr>';
}

$html .= '
    </tbody>
</table>
</page>';

// Create a dynamic filename
$filename = 'sdo_valenzuela_school_data_' . date('Y-m-d') . '.pdf';

// Set the filename and output the PDF
$html2pdf->writeHTML($html);
$html2pdf->output($filename); 
?>
