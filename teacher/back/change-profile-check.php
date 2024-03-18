<?php
session_start();
if(!isset($_SESSION['teaching'])){
    header('location: ../../404.php');
    exit();
}
include_once '../../connect.php';
$password = $_POST['password'];

// check password length
if (mb_strlen($password, 'utf-8') < 6) {
    header("location:../profile.php?short-password=40&id=" . $id); 
    exit;
}
// inputs validations
if (empty($password)) {
    header("location:../profile.php?empty=10&id=");
    exit;
}

// query update
$sql = "UPDATE `users` SET `password` = ? WHERE id = ?";
$result = $connect->prepare($sql);
$result->bindValue(1, $password);
$result->bindValue(2, $_SESSION['user-id']);
if ($result->execute()) {
    header("location:../profile.php?success=20&id=");
} else {
    header("location:../profile.php?error=30&id=");
}
