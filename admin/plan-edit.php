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

$sql2 = "SELECT * FROM `plans` WHERE `id` = ?";
$result2 = $connect->prepare($sql2);
$result2->bindValue(1, $_GET['id']);
$result2->execute();
$plan = $result2->fetch(PDO::FETCH_OBJ);
?>

<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">ویرایش پلن: <?= $plan->name ?></div>
    </div>
    <br>

    <div class="box-content-container">
        <div class="insert">
            <?php if (isset($_GET['editing'])) {
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

            <form action="back/plan-edit-check.php" method="POST">
                <div class="lable">عنوان پلن</div>
                <input type="text" placeholder="عنوان را وارد نمایید..." name="name" value="<?= $plan->name ?>" autocomplete="off">

                <div class="lable">هدف</div>
                <input type="text" placeholder="هدف را وارد نمایید..." name="target" value="<?= $plan->target ?>" autocomplete="off">

                <div class="lable">فعالیت</div>
                <input type="text" placeholder="فعالیت را وارد نمایید..." name="activiti" value="<?= $plan->activity ?>" autocomplete="off">

                <div class="lable">مسئول اجرا</div>
                <select name="implementation">
                    <option disabled>مسئول پیگیری را انتخاب نمایید</option>
                    <?php foreach ($userInfos as $user) :
                        $name = $user['name'];
                        $selectedUser = ($name == $plan->implementation) ? 'selected' : '';
                    ?>
                        <option value="<?= $name ?>" <?= $selectedUser ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="lable">پیگیری توسط</div>
                <select name="track">
                    <option disabled>پیگیری را انتخاب نمایید</option>
                    <?php foreach ($sectionInfos as $section) :
                        $name = $section['name'];
                        $selectedUser = ($name == $plan->track) ? 'selected' : '';
                    ?>
                        <option value="<?= $name ?>" <?= $selectedUser ?>>
                            <?= $name ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="lable">بودجه (افغانی)</div>
                <input type="text" placeholder=" بودجه را وارد نمایید..." name="budget" value="<?= $plan->budget ?>" autocomplete="off">

                <div class="lable">زمان اجرا</div>
                <input type="text" placeholder="زمان اجرا را وارد نمایید..." name="execution_time" value="<?= $plan->execution_time ?>" autocomplete="off">
                <input type="hidden" name="id" value="<?= $plan->id ?>">

                <input type="submit" value="ثبت" class="btn">
            </form>

        </div>
    </div>

</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>