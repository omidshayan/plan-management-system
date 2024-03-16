<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';

include_once '../connect.php';
$sql = "SELECT * FROM `plans` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);

$sql2 = "SELECT * FROM `users` WHERE `name` = ?";
$result2 = $connect->prepare($sql2);
$result2->bindValue(1, $userInfo->implementation);
$result2->execute();
$username = $result2->fetch(PDO::FETCH_OBJ);

?>

<!-- content -->
    <div class="title">
        <div class="title-text">نمایش جزئیات پلن: <?= $userInfo->name ?></div>
    </div>
    <br>
    <div class="box-content-container">
        <div class="details">
            <div class="details-info">
                <ul>
                    <li class="user-details">نام پلن: <?= $userInfo->name ?></li>
                    <li class="user-details">هدف پلن: <?= $userInfo->target ?></li>
                    <li class="user-details">فعالیت: <?= ($userInfo->activity == 2) ? 'رئیس دیپارتمنت' : 'استاد' ?></li>
                    <li class="user-details">مسئول اجرا: <?= $userInfo->implementation ?></li>
                    <li class="user-details">مسئول پیگیری: <?= $userInfo->track ?></li>
                    <li class="user-details">زمان اجرا: <?= $userInfo->execution_time ?></li>
                    <li class="user-details">بودجه: <?= $userInfo->budget ?></li>
                    <li class="user-details">باقیمانده: 21 روز</li>
                </ul>
            </div>
            <div class="details-img"><img src="admin/<?=$username->image?>" alt="dd"></div>

        </div>
        <a href="plans.php" class="color btn p5 d-block">برگشت</a>
    </div>
<!-- end content -->


<?php
include_once 'footer.php';
?>