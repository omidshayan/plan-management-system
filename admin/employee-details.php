<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'sidebar.php';

include_once '../connect.php';
$sql = "SELECT * FROM `users` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ); 
?>

<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">نمایش جزئیات کامل کارمند</div>
    </div>
    <br>

    <div class="box-content-container">
        <div class="details">
            <div class="details-info">
                <ul>
                    <li class="user-details">نام: <?=$userInfo->name?></li>
                    <li class="user-details">شماره موبایل: <?=$userInfo->phone?></li>
                    <li class="user-details">وظیفه: <?= ($userInfo->role == 2) ? 'رئیس دیپارتمنت' : 'استاد' ?></li>
                    <li class="user-details">ایمیل: <?=$userInfo->email?></li>
                    <li class="user-details"> رمزعبور: <?=$userInfo->password?></li>
                    <li class="user-details"> تاریخ ثبت: <?=$userInfo->created_at?></li>
                </ul>
            </div>
            <div class="details-img"><img src="admin/<?=$userInfo->image?>" alt="dd"></div>
        </div>
       <a href="employees.php" class="color btn p5 d-block">برگشت</a>
    </div>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>