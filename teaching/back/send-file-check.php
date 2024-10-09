<?php
session_start();
include_once '../../connect.php';

// get input data
$title = $_POST['title'];
$content = $_POST['description'];
$user_id = $_POST['user_id'];
$user_id_sender = $_SESSION['user-id'];
$datetime = date('Y/m/d H:i:s');

if (empty($_FILES['image']['size'])) {
    header("location:../send-file.php?larg=file_too_large");
    exit;
}

// inputs validations
if (empty($content) || empty($title) || empty($user_id)) {
    header("location:../send-file.php?empty=10");
    exit;
}

// Change img name
if ($_FILES['image']['size'] > 0) {
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $src = "../../assets/documents/" . time() . '.' . $extension;
} else {
    $src = "";
}

// insert query
$sql = "INSERT INTO `documents` (`id`, `title`, `description`, `url`, `user_id`, `user_id_sender`, `created_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
$result = $connect->prepare($sql);
$result->bindValue(1, $title);
$result->bindValue(2, $content);
$result->bindValue(3, $src);
$result->bindValue(4, $user_id);
$result->bindValue(5, $user_id_sender);
$result->bindValue(6, $datetime);
if ($result->execute()) {
    if ($_FILES['image']['size'] > 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], $src);
    }
    header("location:../send-file.php?inserted=20");
}
