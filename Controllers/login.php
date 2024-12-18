<?php
session_start();
require "../DB/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($pass, $user["password"])) {
                    setcookie("user_id", $user["user_id"], time() + (30 * 24 * 60 * 60), "/");
                    $_SESSION['welcome_message'] = "Welcome Home.";
                    $stmt->close();
                    $conn->close();
                    if ($user["role"] === "user") {
                        header("Location: ../pages/Articles/afficherArticles.html");
                    } else {
                        header("Location: ../pages/Admin/backOffice.html");
                    }
                    exit;
                }else{
                    $_SESSION["loginErr"] = "Email or Password is incorrect!";
                }
            }else{
                $_SESSION["loginErr"] = "Email or Password is incorrect!";
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        $conn->close();
        header("Location: ../pages/Auth/login.php");
        exit;
    }
}