<?php
session_start();
$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // In a real app, you'd check a database table, but for now:
    if ($username === "Admin" && $password === "Password@321") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: Healthrecord.php?page=admin"); // Redirect to dashboard
        exit;
    } else {
        $error = "Invalid Username or Password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Login | Campus Care</title>
</head>
<body class="bg-slate-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-teal-600 mb-6 text-center">Admin Access</h2>
        <?php if($error): ?>
            <p class="text-red-500 text-sm mb-4"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required class="w-full border p-3 rounded-xl outline-none focus:ring-2 focus:ring-teal-500">
            <input type="password" name="password" placeholder="Password" required class="w-full border p-3 rounded-xl outline-none focus:ring-2 focus:ring-teal-500">
            <button type="submit" name="login" class="w-full bg-teal-600 text-white py-3 rounded-xl font-bold hover:bg-teal-700 transition">Login to Dashboard</button>
        </form>
    </div>
</body>
</html>