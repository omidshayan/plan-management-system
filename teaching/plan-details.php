<?php
session_start();
if (!isset($_SESSION['teaching'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../lib/jdf.php';

include_once '../connect.php';

$sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.id = plans.implementation) AS `implementation`, (SELECT `name` FROM `sections` WHERE sections.id = plans.track) AS `trackname`, (SELECT `name` FROM `users` WHERE users.id = plans.who_end_plan) AS `who_end_plan` FROM `plans` WHERE `id` = ?";
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
if ($planInfo->status == 1) { ?>
    <a href="back/change-status-plan.php?id=<?= $planInfo->id ?>">
        <div class="end-plan-btn">تغییر به انجام شدن کار</div>
    </a>
<?php } else { ?>
    <a href="back/change-status-plan.php?id=<?= $planInfo->id ?>">
        <div class="change-plan-btn">تغییر به انجام نشدن</div>
    </a>
<?php }
?>

<div class="box-content-container">
    <div class="details">

        <div class="details-info">
            <ul>
                <li class="user-details">نام پلان: <?= $planInfo->name ?></li>
                <li class="user-details">هدف پلان: <?= $planInfo->target ?></li>
                <li class="user-details">فعالیت: <?= ($planInfo->activity == 2) ? 'رئیس دیپارتمنت' : 'استاد' ?></li>
                <li class="user-details">مسئول اجرا: <?= $planInfo->implementation ?></li>
                <li class="user-details">مسئول پیگیری: <?= $planInfo->trackname ?></li>
                <li class="user-details">تاریخ ثبت: <?= jdate('Y/m/d', strtotime($date[0])) ?></li>
                <li class="user-details">زمان اجرا: <?= $shamsi_month ?></li>
                <li class="user-details">ثبت شده توسط: <?= $planInfo->who_it_added ?></li>
                <li class="user-details"> بودجه: <?= ($planInfo->budget) ? $planInfo->budget : ' - - - - ' ?></li>
                <?php
                if ($planInfo->status == 1) { ?>
                    <li class="user-details" style="color: <?= $time_left_color ?>">زمان باقیمانده: <?= $time_left_text ?></li>
                <?php } else { ?>
                    <li class="user-details">تاریخ اتمام کار: <?= jdate('Y/m/d', strtotime($planInfo->updated_at)) ?></li>
                <?php }
                ?>
                <?php
                if ($planInfo->status == 2) { ?>
                    <li class="user-details">تغییر وضعیت توسط: <?= $planInfo->who_end_plan ?></li>
                    <?php } ?>
                    <li class="user-details" style="color: <?= $status_color ?>">وضعیت: <?= $status_text ?></li>

            </ul>
        </div>

    </div>
    <a href="plans.php" class="color btn p5 d-block">برگشت</a>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>