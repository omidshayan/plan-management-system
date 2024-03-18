<?php
session_start();
if (!isset($_SESSION['teaching'])) {
    header('location: ../../404.php');
    exit();
}
include_once '../../connect.php';
$id = $_GET['id'];
$date = date('Y/m/d');
$user = $_SESSION['user-id'];

$userInfo = "SELECT `status` FROM `plans` WHERE `id` = ?";
$result = $connect->prepare($userInfo);
$result->bindValue(1, $id);
$result->execute();
$row = $result->fetch();
if (!$row) { 
    header("location:../plan-details.php?notFound=plan&id=" . $id);
    exit;
}

$status = $row['status']; 
$newStatus = ($status == 1) ? 2 : 1; 

// query update
$sql = "UPDATE `plans` SET `status` = ?, who_end_plan = ?, `updated_at` = ? WHERE id = ? ";
$result = $connect->prepare($sql);
$result->bindValue(1, $newStatus);
$result->bindValue(2, $user);
$result->bindValue(3, $date);
$result->bindValue(4, $id);
if ($result->execute()) {
    header("location:../plan-details.php?success=20&id=" . $id);
} else {
    header("location:../plan-details.php?error=30&id=" . $id);
}
?>
