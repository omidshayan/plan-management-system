<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'sidebar.php';
include_once '../connect.php';
$sql = "SELECT * FROM users WHERE id = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_SESSION['user-id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);
?>

<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">پروفایل شما</div>
    </div>
    <br>

    <div class="box-content-container">
        <div class="insert">
            <?php if (isset($_GET['success'])) {
                echo '<span class="success">عملیات با موفقیت انجام شد</span>';
            } ?>
            <?php if (isset($_GET['error'])) {
                echo '<span class="errors">مشکل در ثبت </span>';
            } ?>
            <?php if (isset($_GET['short-password'])) {
                echo '<span class="errors">رمزعبور حداقل باید 6 کاراکتر باشد</span>';
            } ?>
            <?php if (isset($_GET['empty'])) {
                echo '<span class="errors">لطفا قسمت های ستاره دار را وارد نمایید</span>';
            } ?>

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
                <input type="password" id="passwordInput" value="<?=$userInfo->password?>" placeholder="رمز عبور را وارد کنید..." name="password">

                <img src="admin/<?= $userInfo->image ?>" alt="user profile" class="imgProfile">
                <input type="submit" value="ثبت" class="btn">
            </form>

        </div>
    </div>

</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>