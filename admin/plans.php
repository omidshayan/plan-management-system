<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once 'sidebar.php';
?>
<!-- content -->
<div class="content">
    <div class="title">
        <div class="title-text">نمایش پلن ها</div>
    </div>
    <br>
    <div class="content-container">
        <table class="fl-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>هدف</th>
                    <th>فعالیت</th>
                    <th>مسئول اجرا</th>
                    <th>مسئول پیگیری</th>
                    <th>بودجه</th>
                    <th>زمان اجرا</th>
                    <th>ویرایش</th>
                    <th>جزئیات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once '../connect.php';
                $limit = 10;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($currentPage - 1) * $limit;
                $sql = "SELECT * FROM plans LIMIT $start, $limit";
                $result = $connect->query($sql);
                $plans = $result->fetchAll(PDO::FETCH_ASSOC);
                $number = ($currentPage - 1) * $limit + 1;
                foreach ($plans as $plan) { ?>
                    <tr>
                        <td><?= $number ?></td>
                        <td><?= $plan['name'] ?></td>
                        <td><?= $plan['activity'] ?></td>
                        <td><?= $plan['implementation'] ?></td>
                        <td><?= $plan['track'] ?></td>
                        <td><?= $plan['budget'] ?></td>
                        <td><?= $plan['execution_time'] ?></td>
                        <td><a href="plan-edit.php?id=<?= $plan['id'] ?>"><i class="fas fa-edit"></i></a></td>
                        <td><a href="plan-details.php?id=<?= $plan['id'] ?>" class="success">نمایش</a></td>
                    </tr>
                <?php
                    $number++;
                }
                ?>
            </tbody>
        </table>

        <?php
        $sql = "SELECT COUNT(*) as total FROM users";
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
</div>
<!-- end content -->

<?php
include_once 'footer.php';
?>