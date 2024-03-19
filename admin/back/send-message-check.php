<?php
session_start();
include_once '../../connect.php';

// get input data
$content = $_POST['content'];
$title = $_POST['title'];
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$section_id = isset($_POST['section_id']) ? $_POST['section_id'] : null;
$user_id_sender = $_SESSION['user-id'];
$datetime = date('Y/m/d H:i:s');

// inputs validations
if (empty($content) || empty($title)) {
    header("location:../send-message.php?empty=10");
    exit;
}
if (empty($user_id) && empty($section_id)) {
    header("location:../send-message.php?empty=10");
    $_SESSION['user_input'] = $_POST;
    exit;
}

if (isset($section_id)) {
    $select_sections = "SELECT * FROM users WHERE position = ? ";
    $s_result = $connect->prepare($select_sections);
    $s_result->bindValue(1, $section_id);
    $s_result->execute();
    $users = $s_result->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        foreach ($users as $user) {
            $sql1 = "INSERT INTO `messages` (`id`, `title`, `content`, `user_id_sender`, `user_id`,`section_id` , `created_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
            $result1 = $connect->prepare($sql1);
            $result1->bindValue(1, $title);
            $result1->bindValue(2, $content);
            $result1->bindValue(3, $user_id_sender);
            $result1->bindValue(4, $user['id']);
            $result1->bindValue(5, $section_id);
            $result1->bindValue(6, $datetime);
            $record = $result1->execute();
        }
        if ($record) {
            unset($_SESSION['user_input']);
            header("location:../send-message.php?inserted=20");
            exit();
        } else {
            header("location:../send-message.php?error=30");
            exit();
        }
    } else {
        header("location:../send-message.php?error=30");
        exit();
    }
} else {

    // insert query
    $sql = "INSERT INTO `messages` (`id`, `title`, `content`, `user_id_sender`, `user_id`, `created_at`) VALUES (NULL, ?, ?, ?, ?, ?)";
    $result = $connect->prepare($sql);
    $result->bindValue(1, $title);
    $result->bindValue(2, $content);
    $result->bindValue(3, $user_id_sender);
    $result->bindValue(4, $user_id);
    $result->bindValue(5, $datetime);
    if ($result->execute()) {
        unset($_SESSION['user_input']);
        header("location:../send-message.php?inserted=20");
    } else {
        header("location:../send-message.php?error=30");
    }
}
