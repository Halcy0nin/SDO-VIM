<?php

require __DIR__ . '/../../../vendor/autoload.php';
use Core\Database;
use Core\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = App::resolve(Database::class);

if (isset($_POST['send_recovery_email'])) {

    $user_email = trim($_POST['user_email']);

    $recipientQuery = $db->query(
        "SELECT u.user_name, u.user_id 
         FROM users u
         INNER JOIN school_contacts sc ON u.school_id = sc.school_id
         WHERE sc.contact_email = :user_email",
        ['user_email' => $user_email]
    )->find();
    
    $recipient = $recipientQuery['user_name'];
    $recipientID = $recipientQuery['user_id'];

    // HTML email message
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
            background-color: #22223b;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .header img {
            max-width: 100px;
        }
        .content {
            padding: 40px;
            text-align: center;
        }
        .content h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #22223b;
        }
        .content p {
            font-size: 16px;
            color: #555555;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #22223b;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .footer {
            background-color: #22223b;
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
            <img src="sdo.png">
        </div>
        <!-- Content -->
        <div class="content">
            <h1>Please reset your password</h1>
            
                        <p>Hi <strong>' . $recipient . '</strong>,</p>
                        <p>Your request has been received. Please click the button below to reset your password:</p>
                        <a href="http://localhost:8888/set-new-password/' . $recipientID . '"><button class="btn">Set a new password</button></a>
                        <p>If you did not request a password change, kindly disregard this email.</p>
                        <p>Regards,<br>SDO Valenzuela - ICT Coordinator</p>
                    </div>
                </div>
            </body>
            </html>';

            

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

    $mail->Subject = 'Password Reset';
    $mail->Body    = $message;

    // Send email and handle response
    if($mail->send()) {
        toast('Recovery Email Sent. Please Check your Email.');
        redirect('/');
        exit;
    } else {
        toast('Recovery Email Not Sent. Please contact the ICT Coordinator.');
        redirect('/');
        exit;
    }
}

?>
