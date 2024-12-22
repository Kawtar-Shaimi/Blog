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

    $category_name = trim($_POST['category_name']);
    $isValid = true;

    if (empty($category_name) || strlen($category_name) > 100) {
        $_SESSION['categoryNameErr'] = "Category name is required and must be 100 characters or less.";
        $isValid = false;
    }

    if ($isValid) {
        try {
            $userId = $_COOKIE['user_id'] ?? null;
            $sql = "INSERT INTO categories (category_name) VALUES (?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("s", $category_name);
            $stmt->execute();
            $_SESSION['message'] = "Category Added Successfully";
            $stmt->close();
            $conn->close();
            header("Location: ../../../pages/Admin/Categories/afficherCategories.php");
            exit;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        header("Location: ../../../pages/Admin/Categories/ajouterCategory.php");
        exit;
}
}