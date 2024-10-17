<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

// Filter the CSV data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Initialize the variable to hold CSV data
$excelData = "";

// CSV file name for download 
$fileName = "sdo_val_users_data_" . date('Y-m-d') . ".csv";

//Initialize rowCount to check if results are returned by the query
$rowCount = "";

//Initialize result to store data from query and later parse
$result = "";

// Table header
$headers = [
    'User ID',
    'User Name',
    'User Role',
    'School ID',
    'School Name',
    'Contact Name',
    'Contact Number',
    'Contact Email',
    'Date Added',
    'Date Modified'
];

// Add header titles to the CSV data
array_walk($headers, 'filterData');
$excelData .= implode(",", $headers) . "\n";

// Fetch records from database 
$rowCount = $query = $db->query("
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
    LEFT JOIN school_contacts c ON u.school_id = c.school_id
");

if ($rowCount) {
    // Output each row of the data 
    $result = $db->get($result);
    foreach ($result as $row) {
        $lineData = [
            $row['user_id'],
            $row['user_name'],
            $row['role'],
            $row['school_id'] ?? '',
            $row['school'] ?? '',
            $row['contact_name'] ?? '',
            $row['contact_no'] ?? '',
            $row['contact_email'] ?? '',
            $row['date_added'],
            $row['date_modified'],
        ];
        array_walk($lineData, 'filterData');
        $excelData .= implode(",", $lineData) . "\n";
    }
} else {
    $excelData .= 'No records found...' . "\n";
}

// Headers for download 
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render CSV data 
echo $excelData;

exit;
