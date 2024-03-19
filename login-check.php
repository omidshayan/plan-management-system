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
    if ($userData->role == 5) { // admin
        $_SESSION['user-name'] = $userData->name;
        $_SESSION['user-image'] = $userData->image;
        $_SESSION['user-admin'] = 'admin';
        $_SESSION['user-id'] = $userData->id;
        $_SESSION['user-section'] = $userData->position;
        header('location: admin/index.php');
        exit();
    } elseif ($userData->role == 4) { // department admin
        $_SESSION['user-name'] = $userData->name;
        $_SESSION['user-image'] = $userData->image;
        $_SESSION['department-admin'] = 'department-admin';
        $_SESSION['user-id'] = $userData->id;
        header('location: department-admin/index.php');
        exit();
    } elseif ($userData->role == 3) { // deputy admin
        $_SESSION['user-name'] = $userData->name;
        $_SESSION['user-image'] = $userData->image;
        $_SESSION['deputy'] = 'deputy';
        $_SESSION['user-id'] = $userData->id;
        header('location: deputy/index.php');
        exit();
    } elseif ($userData->role == 2) { // teaching manage
        $_SESSION['user-name'] = $userData->name;
        $_SESSION['user-image'] = $userData->image;
        $_SESSION['teaching'] = 'teaching';
        $_SESSION['user-id'] = $userData->id;
        header('location: teaching/index.php');
        exit();
    } else { // teachers
        $_SESSION['user-name'] = $userData->name;
        $_SESSION['user-image'] = $userData->image;
        $_SESSION['teacher'] = 'teacher';
        $_SESSION['user-id'] = $userData->id;
        header('location: teacher/index.php');
        exit();
    }
} else {
    header('location: index.php?error=10');
    exit();
}
