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

    try {
        setcookie("user_id", "", time() - 3600, "/");
        setcookie("user_role", "", time() - 3600, "/");
        header("Location: ../../../pages/Auth/login.php");
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        throw new Exception("Error: " . $e->getMessage());
    }
}