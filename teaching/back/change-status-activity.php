<?php
session_start();
if (!isset($_SESSION['teaching'])) {
    header('location: ../../404.php');
    exit();
}
include_once '../../connect.php';
$id = $_GET['id'];
$textForEnd = $_GET['textForEnd'];
$date = date('Y/m/d');
$user = $_SESSION['user-id'];

$userInfo = "SELECT `status` FROM `activity` WHERE `id` = ?";
$result = $connect->prepare($userInfo);
$result->bindValue(1, $id);
$result->execute();
$row = $result->fetch();
if (!$row) { 
    header("location:../activity-details.php?notFound=plan&id=" . $id);
    exit;
}

$status = $row['status']; 
$newStatus = ($status == 1) ? 2 : 1; 

// query update
$sql = "UPDATE `activity` SET `status` = ?, textForEnd = ?, `updated_at` = ? WHERE id = ? ";
$result = $connect->prepare($sql);
$result->bindValue(1, $newStatus);
$result->bindValue(2, $textForEnd);
$result->bindValue(3, $date);
$result->bindValue(4, $id);
if ($result->execute()) {
    header("location:../activity-details.php?success=20&id=" . $id);
} else {
    header("location:../activity-details.php?error=30&id=" . $id);
}
?>
