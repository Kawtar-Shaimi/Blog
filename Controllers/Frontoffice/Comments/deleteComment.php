<?php

if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role'])) {
    header("Location: ../../../index.php");
}

session_start();
require "../../../DB/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "Session expired or invalid request. Please refresh the page.";
        exit();
    }

    unset($_SESSION['csrf_token']);

    $id_comment = (int) $_POST['id_comment'];
    $id_article = (int) $_POST['id_article'];

    try {
        $sql = "DELETE FROM comments WHERE id_comment = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $stmt->bind_param("i", $id_comment);
        $stmt->execute();
        $_SESSION['message'] = "Comment Deleted Successfully";
        $stmt->close();
        $conn->close();
        header("Location: ../../../pages/Articles/afficherArticle.php?id=$id_article");
        exit;
    } catch (Exception $e) {
        throw new Exception("Error: " . $e->getMessage());
    }
}