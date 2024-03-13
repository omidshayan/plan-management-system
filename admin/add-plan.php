<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'sidebar.php';
include_once '../connect.php';
$sql = "SELECT * FROM users";
$result = $connect->query($sql);
$userInfos = $result->fetchAll(PDO::FETCH_ASSOC);

$sql1 = "SELECT * FROM sections";
$result1 = $connect->query($sql1);
$sectionInfos = $result1->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">ثبت پلن جدید</div>
    </div>
    <br>

    <div class="box-content-container">
        <div class="insert">
            <?php if (isset($_GET['inserted'])) {
                echo '<span class="success">عملیات با موفقیت انجام شد</span>';
            } ?>
            <?php if (isset($_GET['error'])) {
                echo '<span class="errors">مشکل در ثبت کارمند جدید</span>';
            } ?>
            <?php if (isset($_GET['repead'])) {
                echo '<span class="errors">شماره موبایل تکراری است</span>';
            } ?>
            <?php if (isset($_GET['empty'])) {
                echo '<span class="errors">لطفا قسمت های ستاره دار را وارد نمایید</span>';
            } ?>

            <form action="back/add-plan-check.php" method="POST" enctype="multipart/form-data">
                <div class="lable">عنوان پلن</div>
                <input type="text" placeholder="عنوان را وارد نمایید..." name="name" autocomplete="off">

                <div class="lable">فعالیت</div>
                <input type="text" placeholder="عنوان را وارد نمایید..." name="name" autocomplete="off">

                <div class="lable">مسئول اجرا</div>
                <select name="name">
                    <option selected disabled>مسئول اجرا را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $userInfo) : ?>
                        <option value="<?= $userInfo['name'] ?>"><?= $userInfo['name'] ?></option>
                    <?php endforeach; ?>
                </select>


                <div class="lable">پیگیری توسط</div>
                <select name="name">
                    <option selected disabled>مسئول پیگیری را انتخاب نمایید</option>
                    <?php foreach ($sectionInfos as $sectionInfo) : ?>
                        <option value="<?= $sectionInfo['name'] ?>"><?= $sectionInfo['name'] ?></option>
                    <?php endforeach; ?>
                </select>


                <div class="lable">بودجه (افغانی)</div>
                <input type="text" placeholder="شماره موبایل را وارد نمایید..." name="phone" id="phoneField" autocomplete="off">

                <div class="lable">زمان اجرا</div>
                <input type="text" placeholder="ایمیل را وارد نمایید..." name="email" autocomplete="off">

                <input type="submit" value="ثبت" class="btn">
            </form>

        </div>
    </div>

</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>