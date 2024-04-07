<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../index.php');
}
include_once '../connect.php';

$limit = 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $limit;
$sql = "SELECT plans.*, users.name AS implementation_name, sections.name AS track_name FROM plans LEFT JOIN users ON plans.implementation = users.id LEFT JOIN sections ON plans.track = sections.id ORDER BY plans.id DESC LIMIT $start, $limit";
$result = $connect->query($sql);
$plans = $result->fetchAll(PDO::FETCH_ASSOC);
$number = ($currentPage - 1) * $limit + 1;

$columnMapping = array(
    'name' => 'عنوان',
    'target' => 'هدف',
    'activity' => 'فعالیت',
    'implementation_name' => 'مسئول اجرا',
    'track_name' => 'مسئول پیگیری',
    'budget' => 'بودجه',
    'execution_time' => 'زمان اجرا',
);

$file = fopen('user_data.csv', 'w');

// تنظیم کدگذاری UTF-8 برای فایل CSV
fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM (Byte Order Mark) برای کدگذاری UTF-8

// نوشتن سربرگ‌ها (عنوان‌های ستون‌ها) در فایل CSV بر اساس ستون‌های مورد نظر
$header = array_values($columnMapping);
fputcsv($file, $header);

// نوشتن ردیف‌های داده‌ها در فایل CSV بر اساس ستون‌های مورد نظر
foreach ($plans as $plan) {
    $rowData = array();
    $shamsi_month = jdate('F', $plan['execution_time'], '', 'Asia/Kabul', 'fa');
    // $rowData[] = $shamsi_month;

    foreach ($columnMapping as $dbColumnName => $customColumnName) {
        if (array_key_exists($dbColumnName, $plan)) {
            $value = $plan[$dbColumnName];
            $rowData[] = is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'auto') : $value;
        } else {
            $rowData[] = ''; // اگر مقدار برای ستون موجود نبود، یک مقدار خالی درج شود
        }
    }
    fputcsv($file, $rowData);
}

fclose($file);

$destination = 'excel/user_data.csv';
if (rename('user_data.csv', $destination)) {
    header('location:plans.php');
    exit();
}

