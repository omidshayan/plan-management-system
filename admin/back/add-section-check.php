<?php
include_once '../../connect.php';

// get input data
$name = $_POST['name'];
$admin = $_POST['admin'];
$deputy = $_POST['deputy'];
$teaching = $_POST['teaching'];
$description = $_POST['description'];
$datetime = date('Y/m/d H:i:s');

// inputs validations
if (empty($name) || empty($admin) || empty($deputy) || empty($teaching)) {
    header("location:../add-section.php?empty=10");
    exit;
}

// Check if name number already exists
$checkPhoneQuery = "SELECT COUNT(*) as `name` FROM `sections` WHERE `name` = ?";
$checkPhoneStmt = $connect->prepare($checkPhoneQuery);
$checkPhoneStmt->bindValue(1, $name);
$checkPhoneStmt->execute();
$nameCount = $checkPhoneStmt->fetch(PDO::FETCH_ASSOC)['name'];
if ($nameCount > 0) {
    header("location:../add-section.php?repeat=repeat");
    exit;
}

// insert query
$sql = "INSERT INTO `sections` (`id`, `name`, `admin`, `deputy`, `teaching`,`description`, `created_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
$result = $connect->prepare($sql);
$result->bindValue(1, $name);
$result->bindValue(2, $admin);
$result->bindValue(3, $deputy);
$result->bindValue(4, $teaching);
$result->bindValue(5, $description);
$result->bindValue(6, $datetime);
if ($result->execute()) {
    header("location:../add-section.php?inserted=20");
} else {
    header("location:../add-section.php?error=30");
}
