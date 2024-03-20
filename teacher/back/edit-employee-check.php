<?php
session_start();
if (!isset($_SESSION['teacher'])) {
    header('location: ../../404.php');
    exit();
}
include_once '../../connect.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$role = $_POST['role'];
$position = $_POST['position'];
$password = $_POST['password'];
$id = $_POST['id'];
$date = date('Y/m/d');

// inputs validations
if (empty($name) || empty($phone) || empty($role) || empty($password)) {
    header("location:../employee-edit.php?empty=10&id=" . $id);
    exit;
}


if ($role > 1) {
    $userInfo = "SELECT * FROM `users` WHERE `role` = ? AND `position` = ? AND `state` = 1";
    $result = $connect->prepare($userInfo);
    $result->bindValue(1, $role);
    $result->bindValue(2, $position);
    $result->execute();
    $row = 0;
    while ($row_data = $result->fetch(PDO::FETCH_ASSOC)) {
        if ($row_data['id'] != $id) {
            $row++;
        }
    }
    if ($row > 0) {
        header("location:../employee-edit.php?employee=employee&id=" . $id);
        exit;
    }
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
$sql = "UPDATE `users` SET `name` = ?, `role` = ?, `phone` = ?, `password` = ?, `email` = ?, `position` = ?";
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
$result->bindValue(6, $position);

if ($_FILES['image']['size'] > 0) {
    $result->bindValue(7, $src);
    $result->bindValue(8, $id);
} else {
    $result->bindValue(7, $id);
}

if ($result->execute()) {
    if ($_FILES['image']['size'] > 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], $src);
    }
    header("location:../employee-edit.php?editing=20&id=" . $id);
} else {
    header("location:../employee-edit.php?error=30&id=" . $id);
}
