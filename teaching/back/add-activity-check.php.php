<?php
session_start();
include_once '../../connect.php';

// get input data
$name = $_POST['name'];
$date = $_POST['date'];
$content = $_POST['content'];
$datetime = date('Y/m/d H:i:s');
$user_id = $_SESSION['user-id'];
if (empty($name) || empty($content)) {
        header("location:../add-activity.php?empty=10");
        exit;
    }
    
    $date= intval(substr($date, 0, -3));

// insert query
$sql = "INSERT INTO `activity` (`id`, `name`,`content`, `user_id`, `date`, `created_at`) VALUES (NULL, ?, ?, ?, ?, ?)";
$result = $connect->prepare($sql);
$result->bindValue(1, $name);
$result->bindValue(2, $content);
$result->bindValue(3, $user_id);
$result->bindValue(4, $date);
$result->bindValue(5, $datetime);
if ($result->execute()) {
    header("location:../add-activity.php?inserted=20");
} else {
    header("location:../add-activity.php?error=30");
}
