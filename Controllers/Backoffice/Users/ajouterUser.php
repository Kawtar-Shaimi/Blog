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

    $name = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $pass = trim($_POST['password']);
    $confirmPass = trim($_POST['confirm_password']);
    $isValid = true;

    if (empty($name) || strlen($name) > 30) {
        $_SESSION['nameErr'] = "Name is required and must be 30 characters or less.";
        $isValid = false;
    }

    if (empty($email) || strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emailErr'] = "Email is required and must be 100 characters or less.";
        $isValid = false;
    }else{
        $sql = "SELECT email FROM users where email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows >0){
            $_SESSION["emailErr"]="This email already existe";
            $isValid = false;
        }
    }

    if (empty($role) || ($role != "admin" && $role != "user")) {
        $_SESSION["roleErr"] = "Role is required and must be admin or user.";
        $isValid = false;
    }

    if (empty($pass) || strlen($pass) < 8) {
        $_SESSION["passErr"] = "Password is required and must be strong.";
        $isValid = false;
    }

    if(empty($confirmPass)){
        $_SESSION["confirmPassErr"] = "Confirm password is required.";
    }else{
        if($pass != $confirmPass){
            $_SESSION["confirmPassErr"] = "Passwords are Not matching!";
            $isValid = false;
        }
    }

    if ($isValid) {
        try {
            $hashPass = password_hash($pass,PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("ssss", $name, $email, $hashPass, $role);
            $stmt->execute();

            $_SESSION['message'] = "User Added Successfully";

            $stmt->close();
            $conn->close();
            header("Location: ../../../pages/Admin/Users/afficherUsers.php");
            exit;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        header("Location: ../../../pages/Admin/Users/ajouterUser.php");
        exit;
}
}