<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../connect.php';
$id = $_GET['id'];


$sql = "SELECT *, 
        (SELECT `name` FROM `users` WHERE users.id = documents.user_id) AS `username`
    
        FROM `documents` 
        WHERE id = ? ";
$result = $connect->prepare($sql);
$result->bindValue(1, $id);
$result->execute();
$userInfos = $result->fetch(PDO::FETCH_OBJ);
?>

<!-- content -->
<div class="title">
    <div class="title-text">جزئیات فایل</div>
</div>
<br>

<div class="box-content-container">
    <div class="insert">
        فایل ارسال شده توسط شما
        <br>
        <div class="contetn-msg">
            <div class="title-name-msg"> عنوان: </div>
            <div> <?= $userInfos->title ?> </div>
        </div>

        <div class="contetn-msg">
            <div class="title-name-msg"> توضیحات: </div>
            <div> <?= $userInfos->description ?> </div>
        </div>

        <div class="contetn-msg">
            <div class="title-name-msg">گیرنده: </div>
            <?php
            if ($userInfos->user_id) { ?>
                <div> <?= $userInfos->username ?> </div>
            <?php } else { ?>
                <div> بخش <?= $userInfos->sectionName ?> </div>
            <?php }
            ?>
        </div>

        <div class="contetn-msg">
            <div class="title-name-msg"> تاریخ ارسال: </div>
            <div> <?= jdate('Y/m/d', strtotime($userInfos->created_at)) ?> </div>
        </div>
        <a href="<?=CURRENT_DOMAIN.$userInfos->url?>" target="_blank" class="color"><div class="download">دانلود فایل</div></a>
        <a href="files.php" class="color btn p5 d-block">برگشت</a>
    </div>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>