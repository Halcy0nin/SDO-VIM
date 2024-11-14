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

//Initialize rowCount to check if results are returned by the query
$rowCount = "";

//Initialize result to store data from query and later parse
$result = "";

// Table header
$headers = [
    'Item Code',
    'Article',
    'Description',
    'Date Acquired',
    'Status',
    'Source of Funds',
    'Unit Value',
    'Qty',
    'Total Value',
    'Active',
    'Inactive',
];

// Add header titles to the CSV data
array_walk($headers, 'filterData');
$excelData .= implode(",", $headers) . "\n";

// Fetch records from database 
$rowCount = $query = $db->query('
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
    ]);

    $statusMap = [
        1 => 'Working',
        2 => 'Need Repair',
        3 => 'Condemned'
    ];

if($rowCount){ 
    // Output each row of the data 
    $result = $db->get($result);
    foreach ($result as $row) { 
        $lineData = [
            $row['item_code'],
            $row['item_article'],
            $row['item_desc'],
            $row['date_acquired'],
            $statusMap[$row['item_status']],
            $row['item_funds_source'],
            $row['item_unit_value'],
            $row['item_quantity'],
            $row['item_total_value'],
            $row['item_active'],
            $row['item_inactive']
        ]; 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode(",", $lineData) . "\n"; 

        // CSV file name for download 
        $fileName = "sdo_val_" . $row['school_name'] . "_inventory_data_" . date('Y-m-d') . ".csv"; 
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
