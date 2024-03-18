<?php
session_start();
if (!isset($_SESSION['teaching'])) {
    header('location: ../../404.php');
    exit();
}
include_once '../../connect.php';

// get input data
$name = $_POST['name'];
$description = $_POST['description'];
$id = $_POST['id'];

// inputs validations
if (empty($name)) {
    header("location:../section-edit.php?empty=10&id=" . $id);
    exit;
}

// check phone number
$checkPhoneQuery = "SELECT COUNT(*) as total FROM `sections` WHERE `name` = ? AND `id` != ?";
$checkPhoneStmt = $connect->prepare($checkPhoneQuery);
$checkPhoneStmt->bindValue(1, $name);
$checkPhoneStmt->bindValue(2, $id);
$checkPhoneStmt->execute();
$phoneCount = $checkPhoneStmt->fetch(PDO::FETCH_ASSOC)['total'];

if ($phoneCount > 0) {
    header("location:../section-edit.php?repeat=repeat&id=" . $id);
    exit;
}

// query update
$sql = "UPDATE `sections` SET `name` = ?, `description` = ? WHERE id = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $name);
$result->bindValue(2, $description);
$result->bindValue(3, $id);


if ($result->execute()) {
    header("location:../section-edit.php?inserted=20&id=" . $id);
} else {
    header("location:../section-edit.php?error=30&id=" . $id);
}
