<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once '../connect.php';
$date = date('Y-m-d');
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$sql = "SELECT plans.*, users.name AS implementation_name, sections.name AS track_name FROM plans LEFT JOIN users ON plans.implementation = users.id LEFT JOIN sections ON plans.track = sections.id ORDER BY plans.id DESC";
$result = $connect->query($sql);
$plans = $result->fetchAll(PDO::FETCH_ASSOC);
// $number = ($currentPage - 1) * $limit + 1;
$columnMapping = array(
    'name' => 'عنوان',
    'target' => 'هدف',
    'activity' => 'فعالیت',
    'implementation_name' => 'مسئول اجرا',
    'track_name' => 'مسئول پیگیری',
    'budget' => 'بودجه',
    'execution_time' => 'زمان اجرا',
);

$file = fopen($date.'-plans.csv', 'w');

fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

$header = array_values($columnMapping);
fputcsv($file, $header);

foreach ($plans as $plan) {
    $shamsi_month = jdate('F', $plan['execution_time'], '', 'Asia/Kabul', 'fa');
    $rowData = array();
    // $rowData[] = $shamsi_month;

    foreach ($columnMapping as $dbColumnName => $customColumnName) {
        if ($dbColumnName == 'execution_time') {
            $rowData[] = $shamsi_month;
        } elseif (array_key_exists($dbColumnName, $plan)) {
            $value = $plan[$dbColumnName];
            $rowData[] = is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'auto') : $value;
        } else {
            $rowData[] = '';
        }
    }
    fputcsv($file, $rowData);
}
fclose($file);

$destination = 'plans-excel/'.$date.'-plans.csv';
if (rename($date.'-plans.csv', $destination)) {
    echo '<a href="plans-excel/'.$date.'-plans.csv"</a>';
    header('location:plans.php?excel=ok');
    exit();
}
$file = fopen($destination, 'r');
if (flock($file, LOCK_SH | LOCK_NB)) {
    header('location:plans.php?excel=ok');
    flock($file, LOCK_UN);
    exit();
} else {
    echo "فایل بسته است.";
}
fclose($file);
