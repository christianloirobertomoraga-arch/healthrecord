<?php
session_start();
session_unset();
session_destroy();
$destination = $_GET['dest'] ?? 'index.php';
header("Location: " . $destination);
exit();