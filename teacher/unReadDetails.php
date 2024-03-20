<?php
session_start();
if (!isset($_SESSION['teacher'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../lib/jdf.php';

include_once '../connect.php';
$planId = $_GET['id'];
$userId = $_SESSION['user-id'];


$statusUpdate = "UPDATE `plans` SET `seen` = '2' WHERE id = $planId ";
$exe = $connect->prepare($statusUpdate);
$exe->execute();

$sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.id = plans.implementation) AS `implement`, (SELECT `name` FROM `sections` WHERE sections.id = plans.track) AS `trackname`, (SELECT `id` FROM `users` WHERE users.id = plans.implementation) AS `user_id`, (SELECT `name` FROM `users` WHERE users.id = plans.who_end_plan) AS `who_end_plan` FROM `plans` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$planInfo = $result->fetch(PDO::FETCH_OBJ);


$date = explode(' ', $planInfo->created_at);

$current_time = time();

$stored_time = $planInfo->execution_time;

$time_diff = $stored_time - $current_time;

$days_left = round($time_diff / (60 * 60 * 24));

if ($days_left < 0) {
    $time_left_text = abs($days_left) . ' روز گذشته';
    $time_left_color = 'red';
} elseif ($days_left <= 5) {
    $time_left_text = $days_left . ' روز';
    $time_left_color = 'yellow';
} else {
    $time_left_text = $days_left . ' روز';
    $time_left_color = 'inherit';
}

if ($planInfo->status == 2) {
    $status_text = 'انجام شده';
    $status_color = 'green';
} else {
    $status_text = 'انجام نشده';
    $status_color = 'red';
}

$shamsi_month = jdate('F', $planInfo->execution_time, '', 'Asia/Kabul', 'fa');
?>

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
<?php if (isset($_GET['notFount'])) : ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                title: 'خطا در ثبت',
                text: 'پلان مورد نظر یافت نشد!',
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
                text: 'مشکل در تغییر وضعیت پلان!',
                customClass: {
                    'swal2-popup': 'black-background'
                }
            });
        });
    </script>
<?php endif; ?>
<!-- content -->
<div class="title">
    <div class="title-text">نمایش جزئیات پلان: <?= $planInfo->name ?></div>
</div>
<br>
<?php
if (intval($userId) == intval($planInfo->user_id)) {
    if ($planInfo->status == 1) { ?>


        <a href="#" id="openModalBtn">
            <div class="end-plan-btn">تغییر به انجام شدن کار</div>
        </a>
    <?php } else { ?>
        <a href="#" id="openModalBtn">
            <div class="change-plan-btn">تغییر به انجام نشدن</div>
        </a>
<?php }
}

?>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <br>
        <form action="back/change-status-myplan.php">
            <div>ملاحاظات</div>
            <input type="text" name="textForEnd" class="modalInput">

            <input type="hidden" name="id" value="<?= $planInfo->id ?>">
            <div class="btnModal">
                <input type="submit" id="confirmBtn" value="تایید" class="confirmBtn">
                <a href="#" id="cancelBtn" class="cancelBtn">کنسل</a>
            </div>
            <!-- <input type="submit" > -->
        </form>
    </div>
</div>


<script>
    document.getElementById('openModalBtn').onclick = function() {
        document.getElementById('myModal').style.display = 'block';
    }
    document.getElementsByClassName('close')[0].onclick = function() {
        document.getElementById('myModal').style.display = 'none';
    }
    window.onclick = function(event) {
        if (event.target == document.getElementById('myModal')) {
            document.getElementById('myModal').style.display = 'none';
        }
    }
    document.getElementById('cancelBtn').onclick = function() {
        document.getElementById('myModal').style.display = 'none';
    }
</script>
<div class="box-content-container">
    <div class="details">

        <div class="details-info">
            <ul>
                <li class="user-details">نام پلان: <?= $planInfo->name ?></li>
                <li class="user-details">هدف پلان: <?= $planInfo->target ?></li>
                <li class="user-details">فعالیت: <?= ($planInfo->activity) ?></li>
                <li class="user-details">مسئول اجرا: <?= $planInfo->implement ?></li>
                <li class="user-details">مسئول پیگیری: <?= $planInfo->trackname ?></li>
                <li class="user-details">تاریخ ثبت: <?= jdate('Y/m/d', strtotime($date[0])) ?></li>
                <li class="user-details">زمان اجرا: <?= $shamsi_month ?></li>
                <li class="user-details">ثبت شده توسط: <?= $planInfo->who_it_added ?></li>
                <li class="user-details"> بودجه: <?= ($planInfo->budget) ? $planInfo->budget : 'ثبت نشده' ?></li>
                <?php
                if ($planInfo->status == 1) { ?>
                    <li class="user-details" style="color: <?= $time_left_color ?>">زمان باقیمانده: <?= $time_left_text ?></li>
                <?php }
                ?>

                <?php if ($planInfo->status == 2 && isset($planInfo->updated_at)) : ?>
                    <li class="user-details">تاریخ اتمام کار: <?= jdate('Y/m/d', strtotime($planInfo->updated_at)) ?></li>
                <?php endif; ?>

                <?php
                if ($planInfo->status == 2) { ?>
                    <li class="user-details">تغییر وضعیت توسط: <?= $planInfo->who_end_plan ?></li>
                <?php } ?>
                <li class="user-details" style="color: <?= $status_color ?>">وضعیت: <?= $status_text ?></li>

                <?php
                if ($planInfo->status == 2) { ?>
                    <li class="user-details">ملاحظات اتمام پلان: <?= $planInfo->textForEnd ?></li>
                <?php } ?>

            </ul>
        </div>

    </div>
    <a href="unRead.php" class="color btn p5 d-block">برگشت</a>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>