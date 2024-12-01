<?php
use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

// Fetch notification count
$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND created_by != :user_id 
', [
    'user_id' => get_uid(),
])->find();

// Extract the total count
$notificationCount = $notificationCountQuery['total'];

if ($notificationCount > 5) {
    $notificationCount = '5+';
}

$resources = [];

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

// Fetch the total number of repair requests
$resources_count = $db->query('
SELECT 
    COUNT(*) AS total 
FROM 
    repair_requests
')->get();

$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(request_date)) AS earliest_year FROM repair_requests')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? $currentYear;
$years = range($currentYear, $earliestYear);

// Fetch repair request data with item_article
$resources = $db->paginate('
SELECT 
    rr.id,
    rr.item_code,
    s.school_name,
    rr.request_date,
    rr.description,
    si.item_article,
    rr.item_count
FROM 
    repair_requests rr
JOIN 
    schools s ON s.school_id = rr.school_id
JOIN 
    school_inventory si ON si.item_code = rr.item_code
WHERE
    rr.is_active = 1
LIMIT :start, :end
', [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
])->get();

// Render the view
view('resources/repair/index.view.php', [
    'heading' => 'For Repair Resources',
    'years' => $years,
    'notificationCount' => $notificationCount,
    'resources' => $resources,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination
]);
