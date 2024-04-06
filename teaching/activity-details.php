<?php
session_start();
if (!isset($_SESSION['teaching'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../lib/jdf.php';
$userId = $_SESSION['user-id'];
include_once '../connect.php';

$sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.id = activity.user_id) AS `username` FROM `activity` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$planInfo = $result->fetch(PDO::FETCH_OBJ);


$date = explode(' ', $planInfo->created_at);

$current_time = time();

$stored_time = $planInfo->date;

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

$shamsi_month = jdate('F', $planInfo->date, '', 'Asia/Kabul', 'fa');
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
                text: 'فعالیت مورد نظر یافت نشد!',
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
                text: 'مشکل در تغییر وضعیت !',
                customClass: {
                    'swal2-popup': 'black-background'
                }
            });
        });
    </script>
<?php endif; ?>
<!-- content -->
<div class="title">
    <div class="title-text">نمایش جزئیات فعالیت: <?= $planInfo->name ?></div>
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
        <form action="back/change-status-activity.php">
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
                <li class="user-details">نام فعالیت: <?= $planInfo->name ?></li>
                <li class="user-details">توضیحات: <?= $planInfo->content ?></li>
                <li class="user-details">تاریخ ثبت: <?= jdate('Y/m/d', strtotime($date[0])) ?></li>
                <li class="user-details">زمان اجرا: <?= $shamsi_month ?></li>
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
                <?php } ?>
                <li class="user-details" style="color: <?= $status_color ?>">وضعیت: <?= $status_text ?></li>
                <?php
                if ($planInfo->status == 2) { ?>
                    <li class="user-details">ملاحظات اتمام فعالیت: <?= $planInfo->textForEnd ?></li>
                <?php } ?>

            </ul>
        </div>

    </div>
    <a href="activity.php" class="color btn p5 d-block">برگشت</a>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>