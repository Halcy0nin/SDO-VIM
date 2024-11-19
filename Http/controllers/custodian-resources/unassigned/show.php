<?php

// ==========================================
//           This is the Controller 
// ===========================================
// 
// This is where you load the corresponding
// view file for this route if available
// 
// Use the view() function and feed the 
// full path of the view.
// 
// Being the controller file. This is where 
// the data is get, manipulated, and/or
// saved.
//      
// You can pass variables to your view as the
// second parameter of the view function.
//      
// view('notes/{id}', ['notes' => $notes])
//
// view variables are passed as key-value
// pairs as illustrated in the example above.
//

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;
$clearFilter = isset($_POST['clearFilter']);
$searchTerm = trim($_POST['search'] ?? '');

// Notification count query
$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE
        viewed IS NULL
    AND (
        (user_id = :user_id AND (created_by != :user_id OR created_by IS NULL))
        OR is_public = 1
    );
', [
    'user_id' => get_uid()
])->find();

// Extract the total count
$notificationCount = $notificationCountQuery['total'];
if ($notificationCount > 5) { 
    $notificationCount = '5+';
}

// Initialize SQL conditions and parameters
$conditions = ["si.school_id IS NULL"];
$params = [
    'search_code' => '%' . strtolower($searchTerm) . '%',
    'search_article' => '%' . strtolower($searchTerm) . '%',
    'search_desc' => '%' . strtolower($searchTerm) . '%',
    'search_school' => '%' . strtolower($searchTerm) . '%',
];

// Apply date filter only if clearFilter was not clicked
if (!$clearFilter) {
    if ($startDate && $endDate) {
        $conditions[] = "si.date_acquired BETWEEN :startDate AND :endDate";
        $params['startDate'] = $startDate;
        $params['endDate'] = $endDate;
    } elseif ($endDate) {
        $conditions[] = "si.date_acquired <= :endDate";
        $params['endDate'] = $endDate;
    }
}

// Combine search conditions
$conditions[] = "(
    si.item_code LIKE :search_code OR
    si.item_article LIKE :search_article OR
    si.item_desc LIKE :search_desc OR
    s.school_name LIKE :search_school
)";

// Build the final query with conditions
$whereClause = 'WHERE ' . implode(' AND ', $conditions);

// Fetch resources with search and filters applied
$resources = $db->query("
    SELECT 
        si.item_code,
        si.item_article,
        s.school_name,
        si.item_status AS status,
        si.date_acquired
    FROM 
        school_inventory si
    LEFT JOIN 
        schools s ON s.school_id = si.school_id
    $whereClause
    AND 
    si.item_assigned_status = 0
", $params)->get();

// Render view with the data
view('custodian-resources/unassigned/show.view.php', [
    'heading' => 'Unassigned Resources',
    'notificationCount' => $notificationCount,
    'resources' => $resources,
    'startDate' => $startDate,
    'endDate' => $endDate,
    'search' => $searchTerm
]);
