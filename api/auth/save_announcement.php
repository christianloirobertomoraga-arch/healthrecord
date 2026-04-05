<?php
// 1. Connect to Database (Climb out of auth to find config)
include_once '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. Collect and Clean Data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // 3. SQL Query to Insert
    $sql = "INSERT INTO announcements (title, category, content) VALUES ('$title', '$category', '$content')";

    if ($conn->query($sql) === TRUE) {
        // 4. Success! Redirect to the public announcements page to see the result
        header("Location: ../announcements.php?status=posted");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>