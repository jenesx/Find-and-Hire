<?php
session_start();
include 'dbconfig.php';
include 'models.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindHire Dashboard</title>
</head>
<body>
    <h1>Welcome to FindHire</h1>

    <?php if ($role === 'hr'): ?>
        <h2>HR Dashboard</h2>
        <a href="createjob.php">Create a Writer Post</a>

        <h3>Your Writer Posts</h3>
        <?php
        $writerPosts = getWriterPosts($conn);
        while ($post = $writerPosts->fetch_assoc()) {
            echo "<h4>{$post['title']}</h4><p>{$post['description']}</p>";
            $applications = getApplications($conn, $post['id']);
            echo "<h5>Applications:</h5>";
            while ($app = $applications->fetch_assoc()) {
                echo "<p>Applicant ID: {$app['applicant_id']} | Resume: {$app['resume']} | Status: {$app['status']}</p>";
            }
        }
        ?>
    <?php elseif ($role === 'applicant'): ?>
        <h2>Applicant Dashboard</h2>
        <a href="viewjobs.php">View Available Writer Posts</a>
    <?php endif; ?>

    <a href="logout.php">Logout</a>
</body>
</html>