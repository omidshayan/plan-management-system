<?php
session_start();
include_once '../../connect.php';

// get input data
$name = $_POST['name'];
$date = $_POST['date'];
$content = $_POST['content'];
$id = $_POST['id'];
// $datetime = date('Y/m/d H:i:s');
$user_id = $_SESSION['user-id'];
if (empty($name) || empty($content)) {
        header("location:../add-activity.php?empty=10");
        exit;
    }
    
// insert query
$sql = "UPDATE `activity` SET `name` = ?, `content` = ?, `date` = ? WHERE id = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $name);
$result->bindValue(2, $content);
$result->bindValue(3, $date);
$result->bindValue(4, $id);
if ($result->execute()) {
    header("location:../activity.php?inserted=20");
} else {
    header("location:../activity.php?error=30");
}
