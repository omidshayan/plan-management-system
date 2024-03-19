<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';
?>
<!-- content -->
<div class="title">
    <div class="title-text">پیام های خوانده نشده </div>
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

            $select = "SELECT * FROM `users` WHERE id = $id";
            $resultSelect = $connect->prepare($select);
            $resultSelect->execute();
            $date = $resultSelect->fetch(PDO::FETCH_OBJ);

            $limit = 10;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            $start = ($currentPage - 1) * $limit;
            $sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.id = messages.user_id_sender) AS `username` FROM `messages` WHERE user_id = ? AND `status` = 1 LIMIT $start, $limit";
            $result = $connect->prepare($sql);
            $result->bindValue(1, $id);
            $result->execute();
            $userInfos = $result->fetchAll(PDO::FETCH_ASSOC);

            $number = ($currentPage - 1) * $limit + 1;
            foreach ($userInfos as $userInfo) { ?>
                <tr>
                    <td><?= $number ?></td>
                    <td><?= $userInfo['title'] ?></td>
                    <td><?= $userInfo['username']  ? $userInfo['username'] : ' - - - - ' ?></td>
                    <td><a href="unReadMsgDetails.php?id=<?= $userInfo['id'] ?>" class="success">نمایش</a></td>

                </tr>
            <?php
                $number++;
            }

            $msgGroup = "SELECT *, (SELECT `name` FROM `sections` WHERE sections.id = messages.section_id) AS `msgGroup` FROM `messages` WHERE section_id = ? AND `status` = 1 LIMIT $start, $limit";
            $result1 = $connect->prepare($msgGroup);
            $result1->bindValue(1, $date->position);
            $result1->execute();
            $msgGroups = $result1->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($msgGroups as $msgGroup) { ?>
                <tr>
                    <td><?= $number ?></td>
                    <td><?= $msgGroup['title'] ?></td>
                    <td><?= $msgGroup['msgGroup']  ? $msgGroup['msgGroup'] : ' - - - - ' ?></td>
                    <td><a href="unReadMsgDetails.php?id=<?= $msgGroup['id'] ?>" class="success">نمایش</a></td>

                </tr>
            <?php
                $number++;
            }

            ?>
        </tbody>
    </table>

</div>
<!-- end content -->

<?php
include_once 'footer.php';
?>