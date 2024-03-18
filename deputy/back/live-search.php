<?php
// if (!isset($_SESSION['user-admin'])) {
//     header('location: ../../404.php');
//     exit();
// }
include_once '../../connect.php';
$val = $_GET['search'];
$sql = "SELECT * FROM `plans` WHERE `name` LIKE '%{$val}%'";
$result = $connect->query($sql);
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
$count = $result->rowCount();
if ($count != "") {
    foreach ($rows as $row) {
        // echo '<a href="../plans.php?id=' . $row['id'] . '" class="search-item color s-items">' . $row['name'] . '</a>';
        echo '<a href="#" class="search-item color s-items" data-id="' . $row['id'] . '">' . $row['name'] . '</a>';

    }
} else {
    echo '<span class="search-item color no-result" data-id="0">موردی یافت نشد &#128148;&#128555;</span>';
}
?>
