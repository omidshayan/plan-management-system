<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';

include_once '../connect.php';
$sql = "SELECT * FROM `sections` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ); 
?>

<!-- content -->
    <div class="title">
        <div class="title-text">نمایش جزئیات بخش: <?=$userInfo->name?></div>
    </div>
    <br>

    <div class="box-content-container">
        <div class="details">
            <div class="details-info">
                <ul>
                    <li class="user-details">نام بخش: <?=$userInfo->name?></li>
                    <li class="user-details">مدیر: <?=$userInfo->admin?></li>
                    <li class="user-details">معاون: <?= ($userInfo->deputy == 2) ? 'رئیس دیپارتمنت' : 'استاد' ?></li>
                    <li class="user-details">مدیر تدریسی: <?=$userInfo->teaching?></li>
                    <li class="user-details"> ملاحظات: <?=$userInfo->description?></li>
                </ul>
            </div>
        </div>
       <a href="sections.php" class="color btn p5 d-block">برگشت</a>
    </div>
<!-- end content -->


<?php
include_once 'footer.php';
?>