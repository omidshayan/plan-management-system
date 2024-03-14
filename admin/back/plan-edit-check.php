<?php
session_start();
if (!isset($_SESSION['user-admin'])) {
    header('location: ../../404.php');
    exit();
}
include_once '../../connect.php';

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
$id = $_POST['id'];

// inputs validations
if (empty($name) || empty($target) || empty($activiti) || empty($implementation) || empty($execution_time) || empty($track)) {
    header("location:../add-plan.php?empty=10&id=" . $id);
    exit;
}

// query update
$sql = "UPDATE `plans` SET `name` = ?, `target` = ?, `activity` = ?, `implementation` = ?, `track` = ?, `budget` = ?, `execution_time` = ? WHERE id = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $name);
$result->bindValue(2, $target);
$result->bindValue(3, $activiti);
$result->bindValue(4, $implementation);
$result->bindValue(5, $track);
$result->bindValue(6, $budget);
$result->bindValue(7, $execution_time);
$result->bindValue(8, $id);

if ($result->execute()) {
    if ($_FILES['image']['size'] > 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], $src);
    }
    header("location:../plan-edit.php?editing=20&id=" . $id);
} else {
    header("location:../plan-edit.php?error=30&id=" . $id);
}
