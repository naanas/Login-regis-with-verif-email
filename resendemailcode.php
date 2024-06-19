<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function resend_email_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                            // Send using SMTP
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication

        // $mail->SMTPDebug = 3;                                    // Enable verbose debug output

        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->Username   = 'panekin52@gmail.com';                  // SMTP username
        $mail->Password   = 'dlnp pfuv qfok orcf';                  // SMTP password

        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption
        $mail->Port       = 587;                                    // TCP port to connect to

        $mail->setFrom('panekin52@gmail.com', $name);
        $mail->addAddress($email);                                  // Add a recipient

        $mail->isHTML(true); 
        $mail->Subject = 'doooyk Store resend-Email Verification';
        $email_template = "
            <h2>Kamu telah mendaftar akun di doooykStore</h2>
            <h5>Verifikasi email anda untuk login, dengan klik link di bawah ini </h5>
            <br><br>
            <a href='http://localhost/loginemail/verify-email.php?token=$verify_token'>Klik disini</a>
        ";

        $mail->Body = $email_template;
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['resend_email_verif_btn'])) {
    if (!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        
        $checkemail_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($con, $checkemail_query);

        if (mysqli_num_rows($checkemail_query_run) > 0) {
            $row = mysqli_fetch_array($checkemail_query_run);
            if ($row['verify_status'] == '0') {
                $name = $row['name'];
                $email = $row['email'];
                $verify_token = $row['verify_token'];

                resend_email_verify($name, $email, $verify_token);

                $_SESSION['status'] = 'Link email verif sudah di kirimkan ke email';
                header('Location: login.php');
                exit(0);
            } else {
                $_SESSION['status'] = 'Email sudah terverif';
                header('Location: resendemail.php');
                exit(0);
            }
        } else {
            $_SESSION['status'] = 'Email belum terdaftar';
            header('Location: register.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = 'Masukan email anda';
        header('Location: resendemail.php');
        exit(0);
    }
}
?>
