<?php
session_start();
if (!isset($_SESSION['teacher'])) {
    header('location: ../index.php');
}
include_once 'header.php';
?>
<!-- content -->
<div class="title">
    <div class="title-text">فایل های دریافتی </div>
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
            $sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.id = documents.user_id_sender) AS `username` FROM `documents` WHERE user_id = ? ORDER BY id DESC LIMIT $start, $limit";
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
                    <td><a href="get-file-details.php?id=<?= $userInfo['id'] ?>" class="success">نمایش</a></td>

                </tr>
            <?php
                $number++;
            }
            ?>
        </tbody>
    </table>

    <?php
    $totalRecords = $userInfosCount;
    $totalPages = ceil($totalRecords / $limit);
    ?>
    <div class="tabel-info">
        <div class="countRow">
            تعداد کل: <?= $totalRecords ?>
        </div>
        <?php if ($totalPages > 1) : ?>
            <ul class="pagination">
                <?php
                $startPage = max(1, $currentPage - 3);
                $endPage = min($totalPages, $startPage + 3);

                if ($currentPage > 1) {
                    echo '<li><a href="?page=' . ($currentPage - 1) . '" class="paginate-item"><i class="fas fa-chevron-right"></i></a></li>';
                }

                if ($startPage > 1) {
                    echo '<li><a href="?page=1" class="paginate-item">1</a></li>';
                }

                for ($i = $startPage; $i <= $endPage; $i++) {
                    $active = ($i == $currentPage) ? 'active' : '';
                    echo '<li><a class="paginate-item ' . $active . '" href="?page=' . $i . '">' . $i . '</a></li>';
                }

                if ($endPage < $totalPages) {
                    echo '<li><a class="paginate-item" href="?page=' . $totalPages . '">' . $totalPages . '</a></li>';
                }

                if ($currentPage < $totalPages) {
                    echo '<li><a href="?page=' . ($currentPage + 1) . '" class="paginate-item"><i class="fas fa-chevron-left"></i></a></li>';
                }
                ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<!-- end content -->

<?php
include_once 'footer.php';
?>