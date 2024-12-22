<?php

if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role'])) {
    header("Location: ../../../index.php");
}else{
    if ($_COOKIE['user_role'] != 'admin') {
        header("Location: ../../../index.php");
    }
} 

session_start();
require "../../../DB/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "Session expired or invalid request. Please refresh the page.";
        exit();
    }

    unset($_SESSION['csrf_token']);

    $id_category = (int) $_POST['id_category'];

    try {
        $sql = "DELETE FROM categories WHERE id_category = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        $stmt->bind_param("i", $id_category);
        $stmt->execute();
        $_SESSION['message'] = "Category Deleted Successfully";
        $stmt->close();
        $conn->close();
        header("Location: ../../../pages/Admin/Categories/afficherCategories.php");
        exit;
    } catch (Exception $e) {
        throw new Exception("Error: " . $e->getMessage());
    }
}