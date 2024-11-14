<?php
require __DIR__ . '/../../../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

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

$html2pdf = new Html2Pdf('L', 'LEGAL', 'en', false, 'UTF-8', array(10, 10, 10, 10));

$date = date('m/d/Y h:i:s a', time());

// Start building the HTML content
$html = '
<page backtop="30mm" backbottom="30mm"> 
    <page_header> 
       <img src="../public/export-headers/sdo_header.png" style="width:60%;height:25%;" />             
    </page_header>
    <h1 style="margin:70;"> All Users Data </h1>
    <h4 style="margin: 0px; margin-top: -40px; margin-left: -40px;">Generated on: ' . $date . '</h4>
    <table class="table table-striped" style="width: 97%; word-wrap: break-word; overflow-wrap: break-word; border-collapse: collapse; margin: -15px; margin-top: 10px;">
        <thead>
            <tr>
                <th style="text-align: center; width: 14%; height: 7%; border: 2px solid black;">ID</th>
                <th style="text-align: center; width: 3%; border: 2px solid black;">Username</th>
                <th style="text-align: center; width: 7%; border: 2px solid black;">Role</th>
                <th style="text-align: center; width: 5%; border: 2px solid black;">School</th>
                <th style="text-align: center; width: 5%; border: 2px solid black;">Contact Name</th>
                <th style="text-align: center; width: 5%; border: 2px solid black;">Mobile Number</th>
                <th style="text-align: center; width: 10%; border: 2px solid black;">Email</th>
                <th style="text-align: center; width: 7%; border: 2px solid black;">Date Added</th>
                <th style="text-align: center; width: 10%; border: 2px solid black;">Date Modified</th>
            </tr>
        </thead>
        <tbody>';

// Loop through the users and add each row to the table
foreach ($users as $user) {
    $html .= '
        <tr>
            <td style="text-align: center;width: 5%; border: 2px solid black;">' . htmlspecialchars($user['user_id'] ?? '') . '</td>
            <td style="text-align: center; width: 12%; border: 2px solid black;">' . htmlspecialchars($user['user_name'] ?? '') . '</td>
            <td style="text-transform: capitalize; text-align: center; width: 3%; border: 2px solid black;">' . htmlspecialchars($user['role'] ?? '') . '</td>
            <td style="text-align: center; width: 9%; border: 2px solid black;">' . htmlspecialchars($user['school'] ?? '') . '</td>
            <td style="text-align: center; width: 9%; border: 2px solid black;">' . htmlspecialchars($user['contact_name'] ?? '') . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($user['contact_no'] ?? '') . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($user['contact_email'] ?? '') . '</td>
            <td style="text-align: center; width: 9%; border: 2px solid black;">' . htmlspecialchars($user['date_added'] ?? '') . '</td>
            <td style="text-align: center; width: 10%; border: 2px solid black;">' . htmlspecialchars($user['date_modified'] ?? '') . '</td>
        </tr>';
}

$html .= '
        </tbody>
    </table>
</page>';

// Create a dynamic filename
$filename = 'sdo_val_user_data_' . date('Y-m-d') . '.pdf';

// Set the filename and output the PDF
$html2pdf->writeHTML($html);
$html2pdf->output($filename);
?>
