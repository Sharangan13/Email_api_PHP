<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $inquiry = $data['inquiry'];
    $message = $data['message'];


    try {
        // Server settings
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.zoho.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpmailer->Port = 587;
        $phpmailer->Username = '';                        // 
        $phpmailer->Password = '';                        // 

        // Recipients
        $phpmailer->setFrom($email, $name);
        $phpmailer->addReplyTo($email, $name);
        $phpmailer->addAddress('sharangan07@gmail.com'); 

        // Content
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'User Inquiry';
        $phpmailer->Body = "
            <div style=\"font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;\">
                <div style=\"max-width: 600px; margin: 0 auto; background-color: #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); overflow: hidden;\">
                    <div style=\"background-color: #343a40; color: #ffffff; text-align: center; padding: 20px 0;\">
                        <h2 style=\"margin: 0; font-size:20px;\">Test Email</h2>
                    </div>
                    <div style=\"padding: 20px; color: #333333; font-size:16px;\">
                        <p style=\"font-weight:500;\">This is a test email sent to Mailtrap to verify email functionality.</p>
                        <p style=\"font-weight:600; font-size:17px;\">Name: {$name}</p>
                        <p style=\"font-weight:600; font-size:17px;\">Email: {$email}</p>
                        <p style=\"font-weight:600; font-size:17px;\">Phone: {$phone}</p>
                        <p style=\"font-weight:600; font-size:17px;\">Inquiry: {$inquiry}</p>
                        <p style=\"font-weight:600; font-size:17px;\">Message: {$message}</p>
                    </div>
                </div>
            </div>
        ";

        $phpmailer->send();
        echo 'Email sent successfully.';
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
    }
} else {
    echo 'Invalid request method.';
}
?>
