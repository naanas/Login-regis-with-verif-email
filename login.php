<?php 
session_start();

if (isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "Kamu sudah dalam kondisi login bray!";
    header("Location: dashboard.php");
    exit();
}
$page_tittle ="Login Form";
include('includes/header.php');
include('includes/navbar.php');

?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                    <?php
                        if(isset($_SESSION['status']))
                        {
                            ?>
                            <div class="alert alert-success">
                                <h5><?= $_SESSION['status'];?></h5>
                            </div>
                            <?php
                            unset($_SESSION['status']);
                        }
                        ?>

                <div class="card shadow">
                    <div class="card-header bg-dark">
                        <h5>
                            Login form
                        </h5>
                    </div>
                    <div class="card-body bg-dark">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login-btn" class="btn btn-primary">Login Now !</button>
                            </div>
                            <br>
                            <h6>
                            Email ga terkirim? mau resend email? <a href="resendemail.php"> klik disini </a>
                        </h6>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php')?>