<?php
session_start();
if(!isset($_SESSION['user-admin'])){
    header('location: ../../404.php');
    exit();
}
include_once '../../connect.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$role = $_POST['role'];
$password = $_POST['password'];
$id = $_POST['id'];
$date = date('Y/m/d');

// inputs validations
if (empty($name) || empty($phone) || empty($role) || empty($password)) {
    header("location:../employee-edit.php?empty=10&id=" . $id);
    exit;
}

// check phone number
$checkPhoneQuery = "SELECT COUNT(*) as total FROM `users` WHERE `phone` = ? AND `id` != ?";
$checkPhoneStmt = $connect->prepare($checkPhoneQuery);
$checkPhoneStmt->bindValue(1, $phone);
$checkPhoneStmt->bindValue(2, $id);
$checkPhoneStmt->execute();
$phoneCount = $checkPhoneStmt->fetch(PDO::FETCH_ASSOC)['total'];

if ($phoneCount > 0) {
    header("location:../employee-edit.php?repeat=phone_duplicate&id=" . $id);
    exit;
}

// remove image
if ($_FILES['image']['size'] > 0) {
    $getUserImageQuery = "SELECT `image` FROM `users` WHERE `id` = ?";
    $getUserImageStmt = $connect->prepare($getUserImageQuery);
    $getUserImageStmt->bindValue(1, $id);
    $getUserImageStmt->execute();
    $userImage = $getUserImageStmt->fetch(PDO::FETCH_ASSOC)['image'];
    if (!empty($userImage)) {
        unlink("../users-images/" . $userImage);
    }
}

// select image? change img name
if ($_FILES['image']['size'] > 0) {
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $src = "../../assets/users-images/" . time() . '.' . $extension;
} else {
    $src = null;
}

// query update
$sql = "UPDATE `users` SET `name` = ?, `role` = ?, `phone` = ?, `password` = ?, `email` = ?";
if ($_FILES['image']['size'] > 0) {
    $sql .= ", `image` = ?";
}
$sql .= " WHERE `id` = ?";
$result = $connect->prepare($sql);

$result->bindValue(1, $name);
$result->bindValue(2, $role);
$result->bindValue(3, $phone);
$result->bindValue(4, $password);
$result->bindValue(5, $email);

if ($_FILES['image']['size'] > 0) {
    $result->bindValue(6, $src);
    $result->bindValue(7, $id);
} else {
    $result->bindValue(6, $id);
}

if ($result->execute()) {
    if ($_FILES['image']['size'] > 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], $src);
    }
    header("location:../employee-edit.php?editing=20&id=" . $id);
} else {
    header("location:../employee-edit.php?error=30&id=" . $id);
}
