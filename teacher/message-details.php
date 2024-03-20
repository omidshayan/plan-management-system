<?php
session_start();
if (!isset($_SESSION['teacher'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../connect.php';
$id = $_GET['id'];


$sql = "SELECT *, 
        (SELECT `name` FROM `users` WHERE users.id = messages.user_id) AS `username`, 
        (SELECT `name` FROM `sections` WHERE sections.id = messages.section_id) AS `sectionName` 
        FROM `messages` 
        WHERE id = ? ";
$result = $connect->prepare($sql);
$result->bindValue(1, $id);
$result->execute(); 
$userInfos = $result->fetch(PDO::FETCH_OBJ); 
?>

<!-- content -->
<div class="title">
    <div class="title-text">جزئیات پیام</div>
</div>
<br>

<div class="box-content-container">
    <div class="insert">
        پیام ارسال شده توسط شما
        <br>
        <div class="contetn-msg">
            <div class="title-name-msg"> عنوان پیام: </div>
            <div> <?= $userInfos->title ?> </div>
        </div>

        <div class="contetn-msg">
            <div class="title-name-msg"> متن پیام: </div>
            <div> <?= $userInfos->content ?> </div>
        </div>

        <div class="contetn-msg">
            <div class="title-name-msg">گیرنده: </div>
            <?php
                if($userInfos->user_id){ ?>
                <div> <?= $userInfos->username ?> </div>
            <?php }else{ ?>
                <div> بخش <?= $userInfos->sectionName ?> </div>
            <?php }
            ?>
        </div>

        <div class="contetn-msg">
            <div class="title-name-msg"> تاریخ ارسال: </div>
            <div> <?= jdate('Y/m/d', strtotime($userInfos->created_at)) ?> </div>
        </div>

        <a href="messages.php" class="color btn p5 d-block">برگشت</a>

    </div>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>