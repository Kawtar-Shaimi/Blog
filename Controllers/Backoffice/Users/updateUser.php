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

    $id_user = (int) $_POST['id_user'];
    $name = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
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
            if($result->fetch_assoc()['email'] != $_SESSION["user_infos"]["email"]){
                $_SESSION["emailErr"]="This email already existe";
                $isValid = false;
            }
        }
    }

    if (empty($role) || ($role != "admin" && $role != "user")) {
        $_SESSION["roleErr"] = "Role is required and must be admin or user.";
        $isValid = false;
    }

    if ($isValid) {
        try {
            $sql = "UPDATE users SET nom = ?, email = ?, role = ? WHERE id_user = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("sssi", $name, $email, $role, $id_user);
            $stmt->execute();

            $_SESSION['message'] = "User Updated Successfully";

            $stmt->close();
            $conn->close();
            header("Location: ../../../pages/Admin/Users/afficherUsers.php");
            exit;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        header("Location: ../../../pages/Admin/Users/updateUser.php");
        exit;
}
}