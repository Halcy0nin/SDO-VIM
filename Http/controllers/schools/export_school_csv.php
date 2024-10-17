<?php 

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

// Filter the CSV data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

// Initialize the variable to hold CSV data
$excelData = "";

// CSV file name for download 
$fileName = "sdo_val_school_data_" . date('Y-m-d') . ".csv"; 

//Initialize rowCount to check if results are returned by the query
$rowCount = "";

//Initialize result to store data from query and later parse
$result = "";

// Table header
$headers = [
    'School ID',
    'School Name',
    'School Type',
    'School Division',
    'School District',
    'Contact Name',
    'Contact Number',
    'Contact Email',
    'Date Added',
];

// Add header titles to the CSV data
array_walk($headers, 'filterData');
$excelData .= implode(",", $headers) . "\n";

// Fetch records from database 
$rowCount = $query = $db->query('
SELECT 
    s.school_id,
    s.school_name,
    t.school_type AS type,
    d.school_division AS division,
    di.school_district AS district,
    sc.contact_name,
    sc.contact_no,
    sc.contact_email,
    s.date_added
FROM schools s
JOIN types t ON s.type_id = t.id 
JOIN divisions d ON s.division_id = d.id
JOIN districts di ON s.district_id = di.id
LEFT JOIN school_contacts sc ON s.school_id = sc.school_id;
');

if($rowCount){ 
    // Output each row of the data 
    $result = $db->get($result);
    foreach ($result as $row) { 
        $lineData = [
            $row['school_id'],
            $row['school_name'],
            $row['type'],
            $row['division'],
            $row['district'],
            $row['contact_name'],
            $row['contact_no'],
            $row['contact_email'],
            $row['date_added']
        ]; 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode(",", $lineData) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 

// Headers for download 
header("Content-Type: text/csv"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 

// Render CSV data 
echo $excelData; 

exit;
?>
