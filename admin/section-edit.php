<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'sidebar.php';
include_once '../connect.php';
$sql = "SELECT * FROM `sections` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);

$sql = "SELECT * FROM sections";
$result = $connect->query($sql);
$userInfos = $result->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">ویرایش بخش: <?= $userInfo->name ?></div>
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
                <input type="text" placeholder="نام را وارد نمایید..." name="name" value="<?= $userInfo->name ?>" autocomplete="off">


                <div class="lable">رئیس بخش</div>
                <select name="admin">
                    <option disabled>رئیس را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $user) :
                        $name = $user['admin'];
                        $selectedUser = ($name == $userInfo->admin) ? 'selected' : '';
                    ?>
                        <option value="<?= $name ?>" <?= $selectedUser ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>


                <div class="lable">معاون بخش</div>
                <select name="deputy">
                    <option selected disabled>معاون را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $user) :
                        $name = $user['deputy'];
                        $selectedUser = ($name == $userInfo->deputy) ? 'selected' : '';
                    ?>
                        <option value="<?= $name ?>" <?= $selectedUser ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="lable">مدیرت تدریسی بخش</div>
                <select name="teaching">
                    <option selected disabled>مدیر تدریسی را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $user) :
                        $name = $user['teaching'];
                        $selectedUser = ($name == $userInfo->teaching) ? 'selected' : '';
                    ?>
                        <option value="<?= $name ?>" <?= $selectedUser ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>



                <div class="lable">ملاحضات</div>
                <input type="text" placeholder="ملاحضات را وارد نمایید..." value="<?= $userInfo->description ?>" name="description" autocomplete="off">

                <input type="submit" value="ثبت" class="btn">
            </form>

        </div>
    </div>

</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>