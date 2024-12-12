<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

$notificationViewedQuery = $db->query('
    UPDATE notifications
    SET
    viewed = 1
    WHERE viewed IS NULL 
    AND created_by != :user_id 
',[
    'user_id' => get_uid(),
]);

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

$activitycount = $db->query('
SELECT COUNT(*) as total FROM notifications
WHERE
    created_by != :user_id
', [
    'user_id' => get_uid(),
])->get();

$pagination['pages_total'] = ceil($activitycount[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));

$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];


$activitylogs = [];

$activitylogs = $db->paginate('
SELECT
    n.user_id,
    u.user_name AS user_name,
    n.viewed,
    n.title,
    n.message,
    n.date_added
FROM
    notifications n
JOIN
    users u ON n.user_id = u.user_id
WHERE
    n.created_by != :user_id
ORDER BY
    n.date_added DESC;
LIMIT :start,:end
', [
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
    'user_id' => get_uid(),
])->get();

$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE viewed IS NULL
    AND  created_by != :user_id 
',[
    'user_id' => get_uid(),
])->find();

// Extract the total count
$notificationCount = $notificationCountQuery['total'];

if ($notificationCount > 5){
    $notificationCount = '5+';
};

$currentYear = date('Y'); // Current year
$earliestYearQuery = $db->query('SELECT MIN(YEAR(date_added)) AS earliest_year FROM notifications')->find();
$earliestYear = $earliestYearQuery['earliest_year'] ?? date('Y');
$years = range($currentYear, $earliestYear);


view('logs/index.view.php', [
    'heading' => 'System Logs',
    'activitylogs' => $activitylogs,
    'pagination' => $pagination,
    'years' => $years,
    'notificationCount' => $notificationCount
]);