<?php
session_start();
include 'dbconfig.php';
include 'models.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: login.php");
    exit();
}

$writerPosts = getWriterPosts($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Writer Posts</title>
</head>
<body>
    <h1>Available Writer Posts</h1>
    <?php while ($post = $writerPosts->fetch_assoc()): ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?php echo $post['description']; ?></p>
        <a href="applyjob.php?post_id=<?php echo $post['id']; ?>">Apply</a>
    <?php endwhile; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>