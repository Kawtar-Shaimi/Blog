<?php

if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role'])) {
    header("Location: ../../index.php");
}

session_start();
require "../../DB/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "Session expired or invalid request. Please refresh the page.";
        exit();
    }

    unset($_SESSION['csrf_token']);

    $title = trim($_POST['titre']);
    $content = trim($_POST['content']);
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $img = $_FILES['img'];
        $imgName = $img['name'];
        $uniqueImgName = uniqid('article-') . '-' . basename($imgName);
        $imgPath = "./images/articles/$uniqueImgName";
    }
    $categories = $_POST['categories'];
    $isValid = true;

    if (empty($title) || strlen($title) > 100) {
        $_SESSION['titleErr'] = "Title is required and must be 100 characters or less.";
        $isValid = false;
    }

    if (empty($content)) {
        $_SESSION['contentErr'] = "Content is required.";
        $isValid = false;
    }

    if (!isset($imgPath)) {
        $_SESSION["imgErr"] = "Image is required.";
        $isValid = false;
    }

    if(count($categories) <= 0){
        $_SESSION["categoriesErr"] = "Categories is required.";
    }

    if ($isValid) {
        try {
            $userId = $_COOKIE['user_id'] ?? null;
            $sql = "INSERT INTO articles (titre, content, img, id_user) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("sssi", $title, $content, $imgPath, $userId);
            $stmt->execute();
            $id_article = $stmt->insert_id;
            move_uploaded_file($img['tmp_name'], "../.$imgPath");
            foreach($categories as $id_category){
                $sql = "INSERT INTO categoryArticles (id_category, id_article) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);

                if (!$stmt) {
                    throw new Exception("Database error: " . $conn->error);
                }

                $stmt->bind_param("ii", $id_category, $id_article);
                $stmt->execute();
            }
            $_SESSION['message'] = "Article Added Successfully";
            $stmt->close();
            $conn->close();
            header("Location: ../../pages/Articles/userArticles.php");
            exit;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        header("Location: ../../pages/Articles/ajouterArticle.php");
        exit;
}
}