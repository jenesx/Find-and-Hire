<?php
session_start();
include 'dbconfig.php';
include 'models.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'applicant') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $resume = $_POST['resume'];
    $applicant_id = $_SESSION['user_id'];

    if (applyWriterPost($conn, $post_id, $applicant_id, $resume)) {
        header("Location: dashboard.php?success=Application submitted");
    } else {
        echo "Error submitting application!";
    }
}

$post_id = $_GET['post_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Writer Post</title>
</head>
<body>
    <h1>Apply for Writer Post</h1>
    <form method="POST" action="">
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <textarea name="resume" placeholder="Paste your resume here" required></textarea>
        <button type="submit">Apply</button>
    </form>
    <a href="viewjobs.php">Back to Writer Posts</a>
</body>
</html>
