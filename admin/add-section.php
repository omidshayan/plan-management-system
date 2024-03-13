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
?>

<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">ثبت بخش جدید</div>
    </div>
    <br>

    <div class="box-content-container">
        <div class="insert">
            <?php if (isset($_GET['inserted'])) {
                echo '<span class="success">عملیات با موفقیت انجام شد</span>';
            } ?>
            <?php if (isset($_GET['error'])) {
                echo '<span class="errors">مشکل در ثبت </span>';
            } ?>
            <?php if (isset($_GET['repeat'])) {
                echo '<span class="errors"> نام تکراری است</span>';
            } ?>
            <?php if (isset($_GET['empty'])) {
                echo '<span class="errors">لطفا قسمت های ستاره دار را وارد نمایید</span>';
            } ?>

            <form action="back/add-section-check.php" method="POST">
                <div class="lable">نام بخش</div>
                <input type="text" placeholder="نام را وارد نمایید..." name="name" autocomplete="off">

                <div class="lable">رئیس بخش</div>
                <select name="admin">
                    <option selected disabled>رئیس را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $userInfo) : ?>
                        <option value="<?= $userInfo['name'] ?>"><?= $userInfo['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="lable">معاون بخش</div>
                <select name="deputy">
                    <option selected disabled>معاون را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $userInfo) : ?>
                        <option value="<?= $userInfo['name'] ?>"><?= $userInfo['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="lable">مدیرت تدریسی بخش</div>
                <select name="teaching">
                    <option selected disabled>مدیر تدریسی را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $userInfo) : ?>
                        <option value="<?= $userInfo['name'] ?>"><?= $userInfo['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="lable">ملاحضات</div>
                <input type="text" placeholder="ملاحضات را وارد نمایید..." name="description" autocomplete="off">

                <input type="submit" value="ثبت" class="btn">
            </form>

        </div>
    </div>

</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>