<?php
session_start();
include 'dbconfig.php';
include 'models.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID and role
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle creating a new writer post (HR role)
    if (isset($_POST['create_writer_post'])) {
        if ($user_role !== 'hr') {
            echo "Unauthorized action.";
            exit();
        }

        $title = $_POST['title'];
        $description = $_POST['description'];

        if (empty($title) || empty($description)) {
            echo "Title and description cannot be empty.";
            exit();
        }

        if (addWriterPost($conn, $title, $description, $user_id)) {
            header("Location: dashboard.php?message=PostCreated");
        } else {
            echo "Error: Could not create the post.";
        }
    }

    // Handle applying for a writer post (Applicant role)
    if (isset($_POST['apply_writer_post'])) {
        if ($user_role !== 'applicant') {
            echo "Unauthorized action.";
            exit();
        }

        $post_id = $_POST['post_id'];
        $resume = $_POST['resume'];

        if (empty($post_id) || empty($resume)) {
            echo "Post ID and resume are required.";
            exit();
        }

        if (applyWriterPost($conn, $post_id, $user_id, $resume)) {
            header("Location: viewjobs.php?message=ApplicationSubmitted");
        } else {
            echo "Error: Could not submit the application.";
        }
    }

    // Handle updating application status (HR role)
    if (isset($_POST['update_application_status'])) {
        if ($user_role !== 'hr') {
            echo "Unauthorized action.";
            exit();
        }

        $application_id = $_POST['application_id'];
        $status = $_POST['status'];

        if (empty($application_id) || empty($status)) {
            echo "Application ID and status are required.";
            exit();
        }

        $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $application_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?message=StatusUpdated");
        } else {
            echo "Error: Could not update application status.";
        }
    }
}

// Redirect if no valid action is found
header("Location: dashboard.php");
?>
