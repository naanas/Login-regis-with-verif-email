<?php
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
/**
 * Summary of sendemail_verify
 * @param mixed $name
 * @param mixed $email
 * @param mixed $verify_token
 * @return void
 */
function sendemail_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

    // $mail->SMTPDebug = 3;                                    //Enable verbose debug output

    $mail->Host       = "smtp.gmail.com";                       //Set the SMTP server to send through
    $mail->Username   = "panekin52@gmail.com";                  //SMTP username
    $mail->Password   = "dlnp pfuv qfok orcf";                     //SMTP password

    $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
    $mail->Port       = 587;     

    $mail->setFrom("panekin52@gmail.com", $name);
    $mail->addAddress($email);                                  //Add a recipient

    $mail->isHTML(true); 
    $mail->Subject = "doooyk Store Email Verifycation";
    $email_template = "
    <h2>Kamu telah mendaftar akun di doooykStore</h2>
    <h5>Verifikasi email anda untuk login, dengan klik link di bawah ini </h5>
    <br><br>
    <a href='http://localhost/loginemail/verify-email.php?token=$verify_token'>Klik disini</a>
    ";

    $mail->Body    = $email_template;
    $mail->send();
    echo "Message has been sent";

}

if(isset($_POST['register_button']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());

    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0)
    {
        $_SESSION['status'] = "Email sudah terdaftar !";
        header("Location: register.php");
    }
    else
    {
        $query = "INSERT INTO users (name, phone, email, password, verify_token) VALUES ('$name','$phone','$email','$password','$verify_token')";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            sendemail_verify("$name", "$email", "$verify_token");
            $_SESSION["status"] = "Registrasi BERHASIL, mohon konfirmasi email anda !!!!";
            header("Location: register.php");
        }
        else
        {
             $_SESSION['status'] = "Registrasi GAGAL !";
             header("Location: register.php");
        }

    }

}





