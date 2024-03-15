<?php
date_default_timezone_set('asia/kabul');
include_once 'lib/jdf.php';
$username = 'root';
$password = '';
$dbname = "m_ghalib";

try {
    $connect = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    $connect->exec("set names utf8");
} 

catch (PDOException $e) {
    echo "connection failed: " . $e->getMessage();
}
