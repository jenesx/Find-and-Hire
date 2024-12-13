<?php
session_start();
include 'dbconfig.php';
include 'models.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hr') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $hr_id = $_SESSION['user_id'];

    if (addWriterPost($conn, $title, $description, $hr_id)) {
        header("Location: dashboard.php?success=Writer post created");
    } else {
        echo "Error creating writer post!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Writer Post</title>
</head>
<body>
    <h1>Create a New Writer Post</h1>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit">Create</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>