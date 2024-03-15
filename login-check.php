<?php
session_start();
include_once 'connect.php';

$phone = $_POST['phone'];
$password = $_POST['password'];

$sql = "SELECT * FROM `users` WHERE `phone` = ? AND `password` = ? ";
$result = $connect->prepare($sql);
$result->bindValue(1, $phone);
$result->bindValue(2, $password);
$result->execute();
$userData = $result->fetch(PDO::FETCH_OBJ);
$row = $result->rowCount();

if ($row == 1) {
    $_SESSION['user-name'] = $userData->name;
    $_SESSION['user-id'] = $userData->id;
    $_SESSION['user-image'] = $userData->image;
    $_SESSION['user-admin'] = 'admin';
    header('location: admin/index.php');
    exit();
} else {
    header('location: index.php?error=10');
    exit();
}
