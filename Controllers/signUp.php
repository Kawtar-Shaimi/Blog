<?php
session_start();
require "../DB/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $confirmPass = trim($_POST['confirm_password']);
    $isValid = true;

    if (empty($name) || strlen($name) > 30) {
        $_SESSION['nameErr'] = "Name is required and must be 30 characters or less.";
        $isValid = false;
    }

    if (empty($email) || strlen($email) > 100) {
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

    if (empty($pass) || strlen($pass < 8)) {
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
            $hashPass = password_hash($password,PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (nom, email,password,role) VALUES (?, ?, ?,'user')";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("sss", $name, $email, $hashPass);
            $stmt->execute();
            $user_id = $stmt->insert_id;
            setcookie("user_id", $user_id, time() + (30 * 24*3600),"/");
            $_SESSION['welcome_message'] = "Welcome To The Familly.";
            $stmt->close();
            $conn->close();
            header("Location: ../pages/Articles/afficherArticles.html");
            exit;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        header("Location: ../pages/Auth/signup.php");
        exit;
}
}