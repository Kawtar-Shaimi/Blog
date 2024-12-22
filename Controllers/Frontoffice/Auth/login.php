<?php

if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_role'])) {
    if ($_COOKIE['user_role'] === "user") {
        header("Location: ../../../index.php");
    } else {
        header("Location: ../../../pages/Admin/Articles/afficherArticles.php");
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

    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $isValid = true;

    if (empty($email) || strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emailErr'] = "Invalid email.";
        $isValid = false;
    }

    if (empty($pass) || strlen($pass) < 8) {
        $_SESSION['passErr'] = "Password must be at least 8 characters long.";
        $isValid = false;
    }

    if ($isValid) {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt){
                echo "Database error: " . $conn->error;
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($pass, $user["password"])) {
                    setcookie("user_id", $user["id_user"], time() + 30 * 24 * 3600, "/","",true,true);
                    setcookie("user_role", $user["role"], time() + 30 * 24 * 3600, "/","",true,true);
                    $stmt->close();
                    $conn->close();
                    if ($user["role"] === "user") {
                        header("Location: ../../../index.php");
                    } else {
                        header("Location: ../../../pages/Admin/Articles/afficherArticles.php");
                    }
                    exit;
                }else{
                    $_SESSION["loginErr"] = "Email or Password is incorrect!";
                    $conn->close();
                    header("Location: ../../../pages/Auth/login.php");
                    exit;
                }
            }else{
                $_SESSION["loginErr"] = "Email or Password is incorrect!";
                $conn->close();
                header("Location: ../../../pages/Auth/login.php");
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        $conn->close();
        header("Location: ../../../pages/Auth/login.php");
        exit;
    }
}