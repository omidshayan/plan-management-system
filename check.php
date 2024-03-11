<?php
include_once 'connect.php';

$phone = $_POST['phone'];
$password = $_POST['password'];


$sql = "SELECT * FROM `users` WHERE `phone` = ? AND `password` = ? ";
$result = $connect->prepare($sql);
$result->bindValue(1,$phone);
$result->bindValue(2,$password);
$result->execute();
$row = $result->rowCount();

    if($row == 1){
        header('location: panel.php');
        exit();
    }
    else
    {
        header('location: login.php?error=10');
        exit();
    }

