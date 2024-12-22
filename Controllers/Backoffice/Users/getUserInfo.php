<?php

if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role'])) {
    header("Location: ../../../index.php");
}else{
    if ($_COOKIE['user_role'] != 'admin') {
        header("Location: ../../../index.php");
    }
} 

require "../../../DB/database.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "Session expired or invalid request. Please refresh the page.";
        exit();
    }

    unset($_SESSION['csrf_token']);

    $id_user = (int)$_POST['id_user'];

    try {
        $sql = "SELECT * FROM users where id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_infos = $result->fetch_assoc();

        $_SESSION["user_infos"] = $user_infos;

        header("Location: ../../../pages/Admin/Users/updateUser.php");
        exit;
    } catch (Exception $e) {
        throw new Exception("Error: " . $e->getMessage());
    }
}