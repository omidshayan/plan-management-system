<?php
session_start();
include_once '../../connect.php';

// get data
$name = $_POST['name'];
$target = $_POST['target'];
$activiti = $_POST['activiti'];
if (isset($_POST['implementation'])) {
    $implementation = $_POST['implementation'];
}
if (isset($_POST['track'])) {
    $track = $_POST['track'];
}
$budget = $_POST['budget'];
$execution_time = $_POST['execution_time'];
$who_it_added = $_SESSION['user-name'];
$datetime = date('Y/m/d H:i:s');

// inputs validations
if (empty($name) || empty($target) || empty($activiti) || empty($implementation) || empty($execution_time) || empty($track)) {
    header("location:../add-plan.php?empty=10&id=" . $id);
    exit;
}


$sql = "INSERT INTO `plans` (`id`, `name`, `target`, `activity`, `implementation`, `track`, `budget`, `execution_time`, `who_it_added`, `created_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$result = $connect->prepare($sql);

$result->bindValue(1, $name);
$result->bindValue(2, $target);
$result->bindValue(3, $activiti);
$result->bindValue(4, $implementation);
$result->bindValue(5, $track);
$result->bindValue(6, $budget);
$result->bindValue(7, $execution_time);
$result->bindValue(8, $who_it_added);
$result->bindValue(9, $datetime);

if ($result->execute()) {
    header("location:../add-plan.php?inserted=20");
} else {
    header("location:../add-plan.php?error=30");
}
