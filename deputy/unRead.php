<?php
session_start();
if (!isset($_SESSION['deputy'])) {
    header('location: ../index.php');
}
include_once 'header.php';

?>
<!-- content -->
<div class="title">
    <div class="title-text">پلان های خوانده نشده</div>
</div>
<br>

<div class="content-container">
    <table class="fl-table">
        <thead>
            <tr>
                <th class="th">#</th>
                <th class="th">هدف</th>
                <th class="th">فعالیت</th>
                <th class="th">مسئول اجرا</th>
                <th class="th">مسئول پیگیری</th>
                <th class="th">بودجه</th>
                <th class="th">زمان اجرا</th>
                <th class="th">ویرایش</th>
                <th class="th">جزئیات</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once '../connect.php';
            $userId = $_SESSION['user-id'];

            $limit = 10;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($currentPage - 1) * $limit;
            $sql = "SELECT plans.*, users.name AS implementation_name, sections.name AS track_name 
            FROM plans 
            LEFT JOIN users ON plans.implementation = users.id 
            LEFT JOIN sections ON plans.track = sections.id 
            WHERE plans.implementation = $userId AND `status` = 1 
            ORDER BY plans.id DESC 
            LIMIT $start, $limit";

            $result = $connect->query($sql);
            $plans = $result->fetchAll(PDO::FETCH_ASSOC);
            $number = ($currentPage - 1) * $limit + 1;

            foreach ($plans as $plan) {

                $current_time = time();
                $stored_time = $plan['execution_time'];
                $time_diff = $stored_time - $current_time;
                $days_left = round($time_diff / (60 * 60 * 24));

                if ($days_left < 0) {
                    $time_left_color = 'red';
                } elseif ($days_left <= 5) {
                    $time_left_color = 'yellow';
                } elseif ($plan['status'] === 2) {
                    $time_left_color = 'green';
                } else {
                    $time_left_color = 'inherit';
                }

                $shamsi_month = jdate('F', $plan['execution_time'], '', 'Asia/Kabul', 'fa');
            ?>
                <tr>
                    <td><?= $number ?></td>
                    <td><?= $plan['name'] ?></td>
                    <td><?= $plan['activity'] ?></td>
                    <td><?= $plan['implementation_name'] ?></td>
                    <td><?= $plan['track_name'] ?></td>
                    <td><?= ($plan['budget']) ? $plan['budget'] : ' - - - - ' ?></td>
                    <td style="color: <?= $time_left_color ?>"><?= $shamsi_month ?></td>
                    <td><a href="plan-edit.php?id=<?= $plan['id'] ?>"><i class="fas fa-edit"></i></a></td>
                    <td><a href="unReadDetails.php?id=<?= $plan['id'] ?>" class="success link">نمایش</a></td>
                </tr>
            <?php
                $number++;
            }

            ?>
        </tbody>
    </table>

    <?php
    $sql = "SELECT COUNT(*) as total FROM plans";
    $result = $connect->query($sql);
    $data = $result->fetch(PDO::FETCH_ASSOC);
    $totalRecords = $data['total'];
    $totalPages = ceil($totalRecords / $limit);
    ?>
    <div class="tabel-info">
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