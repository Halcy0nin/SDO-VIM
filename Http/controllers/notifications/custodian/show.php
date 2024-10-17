<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

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
    date_added DESC
LIMIT 5;
', [
    'user_id' => get_uid(),
])->get();

echo json_encode([
    'status' => 'success',
    'data' => $notifications
]);
