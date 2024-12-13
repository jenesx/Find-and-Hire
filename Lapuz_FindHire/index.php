<?php
session_start();
include 'dbconfig.php';
include 'models.php';

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Hire Dashboard</title>
</head>
<body>
    <h1>Hello, welcome to FindHire!</h1>

    <?php if ($role === 'hr'): ?>
        <h2>HR Dashboard</h2>
        <form method="POST" action="handleforms.php">
            <input type="hidden" name="create_writer_post">
            <input type="text" name="title" placeholder="Writer Title" required>
            <textarea name="description" placeholder="Writer Description" required></textarea>
            <button type="submit">Create Writer Post</button>
        </form>

        <h3>Applications</h3>
        <?php
        $writerPosts = getWriterPosts($conn);
        while ($post = $writerPosts->fetch_assoc()) {
            echo "<h4>{$post['title']}</h4>";
            $applications = getApplications($conn, $post['id']);
            while ($app = $applications->fetch_assoc()) {
                echo "<p>Applicant ID: {$app['applicant_id']} | Resume: {$app['resume']} | Status: {$app['status']}</p>";
            }
        }
        ?>
    <?php elseif ($role === 'applicant'): ?>
        <h2>Applicant Dashboard</h2>
        <h3>Available Writer Posts</h3>
        <?php
        $writerPosts = getWriterPosts($conn);
        while ($post = $writerPosts->fetch_assoc()) {
            echo "<h4>{$post['title']}</h4>";
            echo "<p>{$post['description']}</p>";
            echo "<form method='POST' action='handleform.php'>
                <input type='hidden' name='apply_writer_post'>
                <input type='hidden' name='post_id' value='{$post['id']}'>
                <textarea name='resume' placeholder='Paste your resume here' required></textarea>
                <button type='submit'>Apply</button>
            </form>";
        }
        ?>
    <?php endif; ?>

    <a href="logout.php">Logout</a>
</body>
</html>
