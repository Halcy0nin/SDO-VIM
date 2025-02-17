<?php

require __DIR__ . '/../../../vendor/autoload.php';
use Core\Database;
use Core\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_inventory_email') {
    // Ensure the email is sent only once per session
    if (!isset($_SESSION['email_sent']) || $_SESSION['email_sent'] !== true) {
        checkInventoryAndSendEmail(); // Call email sending function
    } else {
        echo "Email has already been sent for this session.";
        exit;
    }
}

function checkInventoryAndSendEmail() {

    $db = App::resolve(Database::class);
    
    //Schools in need of Allocation
    $school_status_query = $db->query('
    SELECT si.school_id, s.school_name, (SUM(si.item_count) / total_items.total_count) * 100 AS affected_percentage, 
    GROUP_CONCAT(CONCAT(si.item_article, " (", si.item_count, ")") SEPARATOR ", ") AS broken_condemned_items FROM  
    (SELECT school_id, item_article, COUNT(*) AS item_count FROM school_inventory WHERE item_status IN (2, 3) 
    GROUP BY school_id, item_article ) si JOIN schools s ON si.school_id = s.school_id 
    JOIN (SELECT school_id, COUNT(*) AS total_count FROM school_inventory GROUP BY school_id ) 
    total_items ON si.school_id = total_items.school_id GROUP BY si.school_id HAVING affected_percentage > 50 
    ORDER BY affected_percentage DESC;'
    );
    $schoolStatus = $school_status_query->get();

    // If no results, redirect without sending an email
    if (empty($schoolStatus)) {
        toast('No schools require urgent allocation.');
        redirect('/');
        exit;
    }

    $recipient = 'SDO - Valenzuela ICT Coordinator';
    $user_email = 'xandrexxenosaquinde@gmail.com';
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #353e5a;
            color: white;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://depedvalenzuela.com/wp-content/uploads/2024/03/DO-LOGO.png" alt="SDO Logo">
        </div>
        <div class="content">
            <h1>Inventory Alert: Critical School Status</h1>
            <p>Hi <strong>' . $recipient . '</strong>,</p>
            <p>The following schools have more than 50% of their inventory marked as <strong>Need Repair</strong> or <strong>Condemned</strong>. Please take action:</p>
            <table>
                <tr>
                    <th>School Name</th>
                    <th>Affected Percentage</th>
                    <th>Items Needing Repair/Condemned</th>
                </tr>';
                foreach ($schoolStatus as $row) {
                    $message .= '<tr>
                        <td>' . htmlspecialchars($row['school_name']) . '</td>
                        <td>' . number_format($row['affected_percentage'], 2) . '%</td>
                        <td>' . htmlspecialchars($row['broken_condemned_items']) . '</td>
                    </tr>';
                }
$message .= '
            </table>
        </div>
        <div class="footer">
            <div class="contact-info">
                <p>For further assistance, please contact the ICT Coordinator.</p>
            </div>
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

    $mail->Subject = 'School Status';
    $mail->Body    = $message;

    // Send email and handle response
    if($mail->send()) {
        toast('Status Report Email Sent. Please Check your Email.');
        redirect('/');
        exit;
    } else {
        toast('Email Not Sent. Please contact the ICT Coordinator.');
        redirect('/');
        exit;
    }
}
?>