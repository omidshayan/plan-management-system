<?php
require_once '../../connect.php';

$userId = $_GET['userId'];
$notificationsQuery = "SELECT * FROM plans WHERE implementation = ? AND `status` = 1 ORDER BY id DESC";
$result = $connect->prepare($notificationsQuery);
$result->bindValue(1, $userId);
$result->execute();
$notifications = $result->fetchAll(PDO::FETCH_ASSOC);

$response = [
    'status' => 'success',
    'notifications' => $notifications,
];
echo json_encode($response);
