<?php
session_start();
if (!isset($_SESSION['department-admin'])) {
    header('location: ../index.php');
}
include_once 'header.php';
?>
<!-- content -->
    <div class="title">
        <div class="title-text">نمایش بخش ها</div>
    </div>
    <br>
    <div class="content-container">
        <table class="fl-table">
            <thead>
                <tr>
                    <th class="th">#</th>
                    <th class="th">نام بخش</th>
                    <th class="th">مدیر</th>
                    <th class="th">معاون</th>
                    <th class="th">مدیر تدریسی</th>
                    <th class="th">ویرایش</th>
                    <th class="th">جزئیات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once '../connect.php';
                $limit = 10;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($currentPage - 1) * $limit;

                // $sql = "SELECT * FROM sections LIMIT $start, $limit";
                $sql = "SELECT *, (SELECT `name` FROM `users` WHERE users.position = sections.id AND users.role = 4) AS `admin`, (SELECT `name` FROM `users` WHERE users.position = sections.id AND users.role = 3) AS `deputy`, (SELECT `name` FROM `users` WHERE users.position = sections.id AND users.role = 2) AS `teaching` FROM `sections` LIMIT $start, $limit";


                // $sql = "SELECT sections.*, users.name AS `admin`
                // FROM sections
                // LEFT JOIN users ON users.position = sections.id
                // LIMIT $start, $limit
                // ";

                $result = $connect->query($sql);
                $userInfos = $result->fetchAll(PDO::FETCH_ASSOC);
                $number = ($currentPage - 1) * $limit + 1;
                foreach ($userInfos as $userInfo) { ?>
                    <tr>
                        <td><?= $number ?></td>
                        <td><?= $userInfo['name'] ?></td>
                        <td><?= $userInfo['admin']  ? $userInfo['admin'] : ' - - - - ' ?></td>
                        <td><?= $userInfo['deputy'] ? $userInfo['deputy'] : ' - - - - ' ?></td>
                        <td><?= $userInfo['teaching'] ? $userInfo['teaching'] : ' - - - - ' ?></td>
                        <td><a href="section-edit.php?id=<?= $userInfo['id'] ?>"><i class="fas fa-edit"></i></a></td>
                        <td><a href="section-details.php?id=<?= $userInfo['id'] ?>" class="success">نمایش</a></td>
                    </tr>
                <?php
                    $number++;
                }
                ?>
            </tbody>
        </table>

        <?php
        $sql = "SELECT COUNT(*) as total FROM sections";
        $result = $connect->query($sql);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $totalRecords = $data['total'];
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