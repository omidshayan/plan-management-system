<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../connect.php';
$sql = "SELECT * FROM users WHERE id = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_SESSION['user-id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);
?>

<!-- content -->
<div class="title">
    <div class="title-text">پروفایل شما</div>
</div>
<br>

<div class="box-content-container">
    <div class="insert">
        <?php if (isset($_GET['short-password'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا در رمزعبور',
                        text: 'رمزعبور حداقل باید 6 کاراکتر باشد!',
                        customClass: {
                            'swal2-popup': 'black-background'
                        }
                    });
                });
            </script>
        <?php endif; ?>
        <?php if (isset($_GET['empty'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا در ثبت',
                        text: 'مشکل در ثبت!',
                        customClass: {
                            'swal2-popup': 'black-background'
                        }
                    });
                });
            </script>
        <?php endif; ?>
        <?php if (isset($_GET['success'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        text: 'عملیات با موفقیت انجام شد!',
                        customClass: {
                            'swal2-popup': 'black-background'
                        }
                    });
                });
            </script>
        <?php endif; ?>
        <?php if (isset($_GET['error'])) : ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا در ثبت',
                        text: 'مشکل در ثبت!',
                        customClass: {
                            'swal2-popup': 'black-background'
                        }
                    });
                });
            </script>
        <?php endif; ?>

        <form action="back/change-profile-check.php" method="POST">
            <div class="lable">نام </div>
            <input type="text" autocomplete="off" value="<?= $userInfo->name ?>" disabled>

            <div class="lable">عنوان وظیفه </div>
            <input type="text" autocomplete="off" value="<?= $userInfo->name ?>" disabled>

            <div class="lable">موبایل</div>
            <input type="text" autocomplete="off" value="<?= $userInfo->phone ?>" disabled>

            <div class="lable">ایمیل</div>
            <input type="text" placeholder="نام را وارد نمایید..." value="<?= $userInfo->email ?>" autocomplete="off" disabled>

            <div class="lable">رمزعبور <span class="info">(می توانید رمزعبور خود را تغییر دهید)</span></div>
            <input type="password" id="passwordInput" value="<?= $userInfo->password ?>" placeholder="رمز عبور را وارد کنید..." name="password">

            <img src="admin/<?= $userInfo->image ?>" alt="user profile" class="imgProfile">
            <input type="submit" value="ثبت" class="btn btn-color">
        </form>

    </div>
</div>
<!-- end content -->


<script>
    var passwordInput = document.getElementById("passwordInput");
    passwordInput.addEventListener("click", function() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
    passwordInput.addEventListener("blur", function() {
        passwordInput.type = "password";
    });
</script>

<?php
include_once 'footer.php';
?>