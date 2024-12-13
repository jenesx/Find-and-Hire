<?php
include 'dbconfig.php';
include 'models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (registerUser($conn, $username, $password, $role)) {
        header("Location: login.php");
    } else {
        $error = "The registration attempt was unsuccessful.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="hr">HR</option>
            <option value="applicant">Applicant</option>
        </select>
        <button type="submit">Register</button>
    </form>
    <p><a href="login.php">Login</a></p>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
