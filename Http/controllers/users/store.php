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
//   view variables are passed as key-value
//   pairs as illustrated in the example above.
//
require __DIR__ . '/../../../vendor/autoload.php';
use Core\Database;
use Core\App;
use Http\Forms\UserAddForm;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$db = App::resolve(Database::class);

try {
    // Validate user input
    $form = UserAddForm::validate($attributes = [
        'user_name' => $_POST['user_name'],
        'password' => $_POST['password'],
        'password_confirm' => $_POST['password_confirm'],
        'school_id' => !empty($_POST['school_id']) ? $_POST['school_id'] : null,
        'user_role' => $_POST['user_role'],
    ]);

    // Hash the password
    $hashed_password = password_hash($attributes['password'], PASSWORD_DEFAULT);

    // Insert the new user into the database
    $db->query('INSERT INTO users (
        user_name,
        role,
        password,
        school_id
    ) VALUES (
        :user_name,
        :role,
        :password,
        :school_id
    )', [
        'user_name' => $_POST['user_name'],
        'role' => $_POST['user_role'],
        'password' => $hashed_password,
        'school_id' => !empty($_POST['school_id']) ? $_POST['school_id'] : null,
    ]);

    $messageUserName = $_POST['user_name'];

    // Step 2: Retrieve the ID of the newly created user
    $newUserQuery = $db->query('SELECT user_id FROM users WHERE user_name = :user_name', [
        'user_name' => $_POST['user_name'], // Use the user_name you just inserted
    ])->find();

    $newUserId = $newUserQuery['user_id'];

    // Step 3: Fetch the email and recipient information
    $userEmailQuery = $db->query('
        SELECT sc.contact_email, u.user_name
        FROM school_contacts sc
        JOIN users u ON sc.school_id = u.school_id
        WHERE u.user_id = :id_to_update
    ',  [
        'id_to_update' => $newUserId, // Use the newly created user's ID
    ])->find();

    // Get email and recipient
    $user_email = $userEmailQuery['contact_email']; // Handle case where email might not be found
    $recipient = $userEmailQuery['user_name']; // Handle case where user name might not be found

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
                <h1>Welcome to our Inventory Management System!</h1>
                <p>Hi <strong>' . htmlspecialchars($recipient) . '</strong>,</p>
                <p>You have successfully been created an account to use at the SDO-Valenzuela Inventory Management System With Resource Allocation.</p>
                <a href="http://localhost:8888/" class="btn">Start Here</a>
            </div>
            <div class="footer">
                <div class="contact-info">
                    <p>If you are not a property custodian, kindly disregard this email.</p>
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
    
    $mail->Subject = 'New Account';
    $mail->Body    = $message;    

    if($mail->send()) {
        toast('Successfully Added User: ' . $messageUserName);
        redirect('/coordinator/users');
        exit;
    } else {
        toast('Failed To Add User: ' . $messageUserName);
        redirect('/coordinator/users');
        exit;
    }
    redirect('/coordinator/users');

} catch (PDOException $e) {
    // Log the error message for debugging
    error_log($e->getMessage());

    // Show an error toast message
    toast('Failed to add user. Please try again.');

    // Redirect back to the user creation form
    redirect('/coordinator/users');

}
