<?php
include_once '../../connect.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$role = $_POST['role'];
$position = $_POST['position'];
$date = date('Y/m/d');
$password = $_POST['password'];

// inputs validations
if (empty($name) || empty($phone) || empty($role) || empty($password)) {
    header("location:../add-employee.php?empty=10&id=" . $id);
    exit;
}

if ($role > 1) {
    $userInfo = "SELECT * FROM `users` WHERE `role` = ? AND `position` = ? AND `state` = 1";
    $result = $connect->prepare($userInfo);
    $result->bindValue(1, $role);
    $result->bindValue(2, $position);
    $result->execute();
    $row = $result->rowCount();
    if ($row > 0) {
        header("location:../add-employee.php?employee=employee");
        exit;
    }
}



// Change img name
if ($_FILES['image']['size'] > 0) {
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $src = "../../assets/users-images/" . time() . '.' . $extension;
} else {
    $src = null;
}

// Check if phone number already exists
$checkPhoneQuery = "SELECT COUNT(*) as total FROM `users` WHERE `phone` = ?";
$checkPhoneStmt = $connect->prepare($checkPhoneQuery);
$checkPhoneStmt->bindValue(1, $phone);
$checkPhoneStmt->execute();
$phoneCount = $checkPhoneStmt->fetch(PDO::FETCH_ASSOC)['total'];

if ($phoneCount > 0) {
    header("location:../add-employee.php?repeat=phone_duplicate");
    exit;
}

$sql = "INSERT INTO `users` (`id`, `name`, `role`, `phone`, `password`, `email`, `image`, `created_at`, `position`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";
$result = $connect->prepare($sql);

$result->bindValue(1, $name);
$result->bindValue(2, $role);
$result->bindValue(3, $phone);
$result->bindValue(4, $password);
$result->bindValue(5, $email);
$result->bindValue(6, $src);
$result->bindValue(7, $date);
$result->bindValue(8, $position);

if ($result->execute()) {
    if ($_FILES['image']['size'] > 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], $src);
    }
    header("location:../add-employee.php?inserted=20");
} else {
    header("location:../add-employee.php?error=30");
}
