<?php
include 'dbconfig.php';


function getWriterPosts($conn) {
    $query = "SELECT * FROM writer_posts";
    return $conn->query($query);
}

function addWriterPost($conn, $title, $description, $hr_id) {
    $stmt = $conn->prepare("INSERT INTO writer_posts (title, description, hr_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $hr_id);
    return $stmt->execute();
}

function getApplications($conn, $post_id) {
    $stmt = $conn->prepare("SELECT * FROM applications WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    return $stmt->get_result();
}

function applyWriterPost($conn, $post_id, $applicant_id, $resume) {
    $stmt = $conn->prepare("INSERT INTO applications (post_id, applicant_id, resume) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $applicant_id, $resume);
    return $stmt->execute();
}

function registerUser($conn, $username, $password, $role) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);
    return $stmt->execute();
}

function authenticateUser($conn, $username, $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}
?>
