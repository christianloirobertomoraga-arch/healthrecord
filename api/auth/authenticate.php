<?php
session_start();
if ($user === $admin_user && $pass === $admin_pass) {
    $_SESSION['role'] = 'admin';
    // Since admin.php is in the same 'auth' folder:
    header("Location: admin.php"); 
    exit();
} else {
    // If login fails, stay in the 'auth' folder:
    header("Location: login.php?error=invalid");
    exit();
}
// Temporary static credentials (Change these or use a Database check here)
$admin_user = "admin";
$admin_pass = "apcas123"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $admin_user && $pass === $admin_pass) {
        $_SESSION['role'] = 'admin';
        $_SESSION['logged_in'] = true;
        header("Location: admin.php"); // Success!
        exit();
    } else {
        header("Location: login.php?error=invalid"); // Failed
        exit();
    }
}
?>