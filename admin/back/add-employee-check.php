<?php
include_once '../../connect.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$role = $_POST['role'];
$date = date('Y/m/d');
$password = $_POST['password'];

// inputs validations
if (empty($name) || empty($phone) || empty($role) || empty($password)) {
    header("location:../add-employee.php?empty=10&id=" . $id);
    exit;
}


// Change img name
if ($_FILES['image']['size'] > 0) {
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $src = "../users-images/" . time() . '.' . $extension;
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
    header("location:../add-employee.php?repead=phone_duplicate");
    exit;
}

$sql = "INSERT INTO `users` (`id`, `name`, `role`, `phone`, `password`, `email`, `image`, `created_at`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
$result = $connect->prepare($sql);

$result->bindValue(1, $name);
$result->bindValue(2, $role);
$result->bindValue(3, $phone);
$result->bindValue(4, $password);
$result->bindValue(5, $email);
$result->bindValue(6, $src);
$result->bindValue(7, $date);

if ($result->execute()) {
    if ($_FILES['image']['size'] > 0) {
        move_uploaded_file($_FILES['image']['tmp_name'], $src);
    }
    header("location:../add-employee.php?inserted=20");
} else {
    header("location:../add-employee.php?error=30");
}
