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
    AND user_id = :user_id
    AND (
        created_by != :user_id OR created_by IS NULL
    )
    OR
    is_public = 1', [
        'user_id' => get_uid(),
    ]);

$notifications = [];

$notifications = [];

$notifications = $db->query('
SELECT
    user_id,
    viewed,
    title,
    message,
    date_added
FROM
    notifications
WHERE
    user_id = :user_id
    AND (
        created_by != :user_id OR created_by IS NULL
    )
OR
    is_public = 1
ORDER BY
    date_added DESC;
', [
    'user_id' => get_uid(),
])->get();

$notificationCountQuery = $db->query('
    SELECT COUNT(*) AS total
    FROM notifications
    WHERE
        viewed IS NULL
    AND (
        (user_id = :user_id AND (created_by != :user_id OR created_by IS NULL))
        OR is_public = 1
    );
',[
    'user_id' => get_uid()
])->find();

// Extract the total count
$notificationCount = $notificationCountQuery['total'];

if ($notificationCount > 5){
    $notificationCount = '5+';
};

view('notifications/custodian/index.view.php', [
    'heading' => 'Notifications',
    'notificationCount' => $notificationCount,
    'notifications' => $notifications,
]);