<?php
include('dbcon.php');

session_start();
if(isset($_POST['login-btn']))
{
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' ";
        $login_query_run = mysqli_query($con, $login_query);

        if(mysqli_num_rows($login_query_run) > 0)
        {
            $row = mysqli_fetch_array($login_query_run);
            if($row['verify_status'] == "1")
            {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'usernname' => $row['name'],
                    'phone' => $row['phone'],
                    'email' => $row['email'],

                ];
                $_SESSION['status'] = "Login sukses yaa!";
                header("Location: dashboard.php");
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "Verifikasi email mu dulu!";
                header("Location: login.php");
                exit(0);
            }


        }
        else
        {
            $_SESSION['status'] = "Email atau Password nya salah cuy!";
            header("Location: login.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "Harus di isi semua ya form nya";
        header("Location: login.php");
        exit(0);
    }

}