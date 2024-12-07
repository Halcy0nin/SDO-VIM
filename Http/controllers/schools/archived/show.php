<?php

use Core\Database;
use Core\App;
use Core\Session;

$db = App::resolve(Database::class);

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

$schools = [];

$pagination = [
    'pages_limit' => 10,
    'pages_current' => isset($_GET['page']) ? (int)$_GET['page'] : 1,
    'pages_total' => 0,
    'start' => 0,
];

$resources_count = $db->query('
SELECT 
    COUNT(*) as total 
FROM 
    schools s
JOIN types t ON s.type_id = t.id 
JOIN divisions d ON s.division_id = d.id
JOIN districts di ON s.district_id = di.id
LEFT JOIN school_contacts sc ON s.school_id = sc.school_id
WHERE (
	s.school_id LIKE :search_id OR
    s.school_name LIKE :search_name OR
    t.school_type LIKE :search_type OR
    d.school_division LIKE :search_division OR
    di.school_district LIKE :search_district OR
    sc.contact_name LIKE :search_contact OR
    sc.contact_email LIKE :search_email OR
    sc.contact_no LIKE :search_no
)
AND
    s.is_archived = 1
', [
    'search_id' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_name' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_type' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_division' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_district' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_contact' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_email' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_no' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
])->get();

$pagination['pages_total'] = ceil($resources_count[0]['total'] / $pagination['pages_limit']);
$pagination['pages_current'] = max(1, min($pagination['pages_current'], $pagination['pages_total']));
$pagination['start'] = ($pagination['pages_current'] - 1) * $pagination['pages_limit'];

if ($resources_count[0]['total'] !== 0) {
    $schools = $db->paginate('
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
        s.date_added,
        r.id AS receipt_id,
        r.receipt,
        r.date_added AS receipt_date_added
    FROM schools s
    JOIN types t ON s.type_id = t.id 
    JOIN divisions d ON s.division_id = d.id
    JOIN districts di ON s.district_id = di.id
    LEFT JOIN school_contacts sc ON s.school_id = sc.school_id
    LEFT JOIN (
        SELECT r1.*
        FROM receipts r1
        WHERE r1.date_added = (
            SELECT MAX(r2.date_added)
            FROM receipts r2
            WHERE r2.school_id = r1.school_id
        )
    ) r ON s.school_id = r.school_id
    WHERE (
        s.school_id LIKE :search_id OR
        s.school_name LIKE :search_name OR
        t.school_type LIKE :search_type OR
        d.school_division LIKE :search_division OR
        di.school_district LIKE :search_district OR
        sc.contact_name LIKE :search_contact OR
        sc.contact_email LIKE :search_email OR
        sc.contact_no LIKE :search_no
    )
    AND
        s.is_archived = 1
    LIMIT :start,:end
', [
    'search_id' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_name' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_type' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_division' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_district' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_contact' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_email' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'search_no' => '%' . strtolower(trim($_POST['search'] ?? '')) . '%',
    'start' => (int)$pagination['start'],
    'end' => (int)$pagination['pages_limit'],
    ])->get();
}

view('schools/archived/index.view.php', [
    'heading' => 'Archived Schools',
    'schools' => $schools,
    'notificationCount' => $notificationCount,
    'errors' => Session::get('errors') ?? [],
    'old' => Session::get('old') ?? [],
    'pagination' => $pagination,
    'search' => $_POST['search']
]);
