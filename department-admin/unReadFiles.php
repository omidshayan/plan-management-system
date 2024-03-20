<?php
session_start();
if (!isset($_SESSION['department-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';
?>
<!-- content -->
<div class="title">
    <div class="title-text">فایل های دیده نشده </div>
</div>
<br>
<div class="content-container">
    <table class="fl-table">
        <thead>
            <tr>
                <th class="th">#</th>
                <th class="th">عنوان</th>
                <th class="th">فرستنده</th>
                <th class="th">جزئیات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once '../connect.php';
            $id = $_SESSION['user-id'];

            $limit = 10;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($currentPage - 1) * $limit;
            $sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.id = documents.user_id_sender) AS `username` FROM `documents` WHERE user_id = ? AND `status` = 1  ORDER BY id DESC LIMIT $start, $limit";
            $result = $connect->prepare($sql);
            $result->bindValue(1, $id);
            $result->execute();
            $userInfos = $result->fetchAll(PDO::FETCH_ASSOC); 
            $userInfosCount = $result->rowCount();
            $number = ($currentPage - 1) * $limit + 1;
            foreach ($userInfos as $userInfo) { ?>
                <tr>
                    <td><?= $number ?></td>
                    <td><?= $userInfo['title'] ?></td>
                    <td><?= $userInfo['username']  ? $userInfo['username'] : ' - - - - ' ?></td>
                    <td><a href="unReadFilesDetails.php?id=<?= $userInfo['id'] ?>" class="success">نمایش</a></td>
                    
                </tr>
            <?php
                $number++;
            }
            ?>
        </tbody>
    </table>
    <?php if (empty($userInfos)) { ?>
    <div class="notFound">موردی یافت نشد</div>
<?php } ?>
</div>
<!-- end content -->

<?php
include_once 'footer.php';
?>