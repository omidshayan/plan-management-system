<?php

session_start();

session_destroy();
unset($_SESSION['user-admin']);
header('location: index.php');
