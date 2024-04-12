<?php
session_start();
  if(isset($_SESSION['user-admin'])){
    header('location: admin/index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://www.ghalib.edu.af/front_asset/images/logo2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css">
    <title>ورود به سیستم</title>
</head>

<body>
        <!-- login form -->
        <div class="login">
            <div class="login-form">
                    <h3>فرم ورود</h3>
                    <?php
                        if(isset($_GET['error'])){
                            echo '<h5 class="error">کاربری یافت نشد</h5>';
                        }
                    ?>
                <div class="avatar-login">
                    <img src="assets/img/profile.png" alt="">
                </div><br>
                <form action="login-check.php" method="POST">
                    <span> شماره موبایل </span><br>
                    <input type="text" name="phone" placeholder=" شماره موبایل خود را وارد کنید..." required><br>
                    <span>رمزعبور</span><br>
                    <input type="password" name="password" placeholder="رمزعبور خود را وارد کنید..." required><br><br>
                    <input type="submit" value=" ورود " class="btn-custom btn-color">
                </form>
            </div>
        </div>

</body>
</html>