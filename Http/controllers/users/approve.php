<?php

//  ==========================================
//           This is the Controller 
// ===========================================
// 
//  This is where you load the corresponding
//  view file for this route if available
// 
//   Use the view() function and feed the 
//   full path of the view.
// 
//   Being the controller file. This is where 
//   the data is get, manipulated, and/or
//   saved.
//      
//   You can pass variables to your view as the
//   second parameter of the view function.
//      
//   view('notes/{id}', ['notes' => $notes])
//
//   view variables are passed as keu-value
//   pairs as illustrated in the example above.
//

require __DIR__ . '/../../../vendor/autoload.php';
use Core\Database;
use Core\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = App::resolve(Database::class);

$userEmailQuery = $db->query('
SELECT sc.contact_email, u.user_name
FROM school_contacts sc
JOIN users u ON sc.school_id = u.school_id
WHERE u.user_id = :id_to_update ;
',  [
    'id_to_update' => $_POST['id_to_update'],
])->find();

$user_email = $userEmailQuery['contact_email'];
$recipient = $userEmailQuery['user_name'];
$new_user_name = $_POST['new_username'];

$message = '
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
        }
        .header {
            background-color: #353e5a;
            padding: 15px;
            text-align: center;
            color: #ffffff;
        }
        .header img {
            max-width: 100px;
            height: auto;
        }
        .content {
            padding: 40px;
            text-align: center;
        }
        .content h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #353e5a;
        }
        .content p {
            font-size: 16px;
            color: #555555;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #353e5a;
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: rgba(67, 79, 114, 0.8);
            color: white;
        }
        .footer {
            background-color: #353e5a;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
        .footer a {
            color: #ffffff;
            margin: 0 10px;
            text-decoration: none;
        }
        .footer .contact-info {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <img src="https://depedvalenzuela.com/wp-content/uploads/2024/03/DO-LOGO.png" alt="SDO Logo">
        </div>
        <!-- Content -->
        <div class="content">
            <h1>Your request has been approved</h1>
            <p>Hi <strong>' . htmlspecialchars($recipient) . '</strong>,</p>
            <p>Your request has been approved. Your new user name is: ' . htmlspecialchars($new_user_name) . '.</p>
            <a href="http://localhost:8888/" class="btn">Go back to Log-In</a>
        </div>
        <div class="footer">
            <div class="contact-info">
                <p>If you did not request a username change, kindly disregard this email.</p>
                <p>Regards,<br>SDO Valenzuela - ICT Coordinator</p>
            </div>
        </div>
    </div>
</body>
</html>
';

// Set up PHPMailer
$mail = new PHPMailer;

$mail->isSMTP();                                      
$mail->Host = 'smtp.gmail.com';  
$mail->SMTPAuth = true;                         
$mail->Username = 'sdovalenzuelainventory@gmail.com'; 
$mail->Password = 'bhwgdknfejfjibyl';                          
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                           
$mail->Port = 587;   

$mail->From = 'SDO_Valenzuela@sdovim.com';
$mail->FromName = 'SDO Valenzuela - ICT Coordinator';
$mail->addAddress($user_email, $recipient);

// Set email format to HTML
$mail->isHTML(true);

$mail->Subject = 'Approved Username Change';
$mail->Body    = $message;

$db->query('UPDATE 
    users u
    JOIN 
        user_requests r ON u.user_id = r.user_id  
    SET 
        u.user_name = :new_username,          
        r.user_status = 2                       
    WHERE 
        r.user_id = :id_to_update                
    AND 
        r.user_status = 1;',  [
    'new_username' => $_POST['new_username'],
    'id_to_update' => $_POST['id_to_update'],
]);


// Send email and handle response
if($mail->send()) {
    toast('Confirmation email successfully sent to requester.');
    redirect('/coordinator/users');
    exit;
} else {
    toast('Confirmation email failed to send to requester.');
    redirect('/coordinator/users');
    exit;
}


