<?php include_once 'header.php';
session_start();
include_once '../connect.php';
$userId = $_SESSION['user-id'];
$sql = "SELECT COUNT(*) AS count_status_1 FROM plans WHERE implementation = $userId";
$result = $connect->prepare($sql);
$result->execute();
$row = $result->fetch(PDO::FETCH_ASSOC);
$count_status = $row['count_status_1'];

$sql = "SELECT COUNT(*) AS count_status_2 FROM plans WHERE `status` = 2 AND implementation = $userId";
$result = $connect->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$count_status_2 = $row['count_status_2'];

$count_status_open = $count_status - $count_status_2;
?>

<div class="report">
    <div class="report-item">
        <div class="report-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="report-text">
            <span>تعداد پلان ها <?= $count_status ?></span>
        </div>
    </div>

    <div class="report-item">
        <div class="report-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="report-text">
            <span>پلان های باز <?= $count_status_open ?></span>
        </div>
    </div>
    <div class="report-item">
        <div class="report-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="report-text">
            <span>پلان های بسته شده <?= $count_status_2 ?></span>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>