<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../lib/jdf.php';

include_once '../connect.php';

$sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.id = plans.implementation) AS `implementation`, (SELECT `name` FROM `sections` WHERE sections.id = plans.track) AS `trackname` FROM `plans` WHERE `id` = ?";
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

// بررسی وضعیت پلان (آیا انجام شده یا نه)
if ($planInfo->status == 2) {
    $status_text = 'انجام شده';
    $status_color = 'green';
} else {
    $status_text = 'انجام نشده';
    $status_color = 'red';
}

$shamsi_month = jdate('F', $planInfo->execution_time, '', 'Asia/Kabul', 'fa');
?>

<!-- content -->
<div class="title">
    <div class="title-text">نمایش جزئیات پلان: <?= $planInfo->name ?></div>
</div>
<br>
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
                <li class="user-details" style="color: <?= $time_left_color ?>">زمان باقیمانده: <?= $time_left_text ?></li>
                <li class="user-details" style="color: <?= $status_color ?>">وضعیت: <?= $status_text ?></li>
                <li class="user-details">بودجه: <?= $planInfo->budget ?></li>
            </ul>
        </div>

    </div>
    <a href="plans.php" class="color btn p5 d-block">برگشت</a>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>