<?php
session_start();
if (!isset($_SESSION['teacher'])) {
    header('location: ../index.php');
}
include_once 'header.php';
include_once '../lib/jdf.php';
include_once '../connect.php';
$sql = "SELECT *, (SELECT `name` FROM `sections` WHERE sections.id = users.position) AS `position` FROM `users` WHERE `id` = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $_GET['id']);
$result->execute();
$userInfo = $result->fetch(PDO::FETCH_OBJ);
$date = explode(' ', $userInfo->created_at);


?>

<!-- content -->
<div class="title">
    <div class="title-text">نمایش جزئیات کامل کارمند</div>
</div>
<br>

<div class="box-content-container">
    <div class="details">
        <div class="details-info">
            <ul>
                <li class="user-details">نام: <?= $userInfo->name ?></li>
                <li class="user-details">شماره موبایل: <?= $userInfo->phone ?></li>
                <li class="user-details">وظیفه:
                    <?php
                    if ($userInfo->role === 1) {
                        echo 'استاد';
                    } elseif ($userInfo->role === 2) {
                        echo 'مدیر تدریسی';
                    } elseif ($userInfo->role === 3) {
                        echo 'رئیس دیپارتمنت';
                    } else {
                        echo 'رئیس: '.$userInfo->position.'';
                    }
                    ?>
                </li>
                <li class="user-details">بخش مربوطه:
                    <?php
                    if ($userInfo->role === 1) {
                        echo $userInfo->position;
                    } elseif ($userInfo->role === 2) {
                        echo $userInfo->position;
                    } elseif ($userInfo->role === 3) {
                        echo $userInfo->position;
                    } else {
                        echo $userInfo->position;
                    }
                    ?>
                </li>
                <li class="user-details">ایمیل: <?= $userInfo->email ?></li>
                <li class="user-details"> رمزعبور: <?= $userInfo->password ?></li>
                <li class="user-details">ثبت شده توسط: <?= $userInfo->who_it_recorded ?></li>
                <li class="user-details"> تاریخ ثبت: <?= jdate('Y/m/d', strtotime($date[0])) ?></li>
            </ul>
        </div>
        <?php
        if (isset($userInfo->image)) { ?>
        <div class="details-img"><img src="admin/<?= $userInfo->image ?>" alt="profile"></div>
        <?php } else { ?>
            <div class="details-img"><img src="../assets/img/avatar.png" alt="dd"></div>
        <?php }
        ?>
    </div>
    <a href="employees.php" class="color btn p5 d-block">برگشت</a>
</div>
<!-- end content -->


<?php
include_once 'footer.php';
?>