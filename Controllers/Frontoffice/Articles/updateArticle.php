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

    $id_article = (int) $_POST['id_article'];
    $title = trim($_POST['titre']);
    $content = trim($_POST['content']);

    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $img = $_FILES['img'];
        $imgName = $img['name'];
        $uniqueImgName = uniqid('article-') . '-' . basename($imgName);
        $imgPath = "./images/articles/$uniqueImgName";
    }else{
        $imgPath = $_SESSION["article_infos"]['img'];
    }

    $categories = $_POST['categories'] ?? null;
    $isValid = true;

    if (empty($title) || strlen($title) > 100) {
        $_SESSION['titleErr'] = "Title is required and must be 100 characters or less.";
        $isValid = false;
    }

    if (empty($content)) {
        $_SESSION['contentErr'] = "Content is required.";
        $isValid = false;
    }

    if ($isValid) {
        try {
            $sql = "UPDATE articles SET titre = ?, content = ?, img = ? WHERE id_article = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }

            $stmt->bind_param("sssi", $title, $content, $imgPath, $id_article);
            $stmt->execute();

            if($imgPath != $_SESSION["article_infos"]['img']){
                $oldImgPath = "../../.". $_SESSION["article_infos"]['img'];
                if (file_exists($oldImgPath)) {
                    if (unlink($oldImgPath)) {
                        move_uploaded_file($img['tmp_name'], "../../.$imgPath");
                    }
                }
            }

            if($categories){
                if(count($categories) > 0){
                    $sql = "DELETE FROM categoryArticles WHERE id_article = ?";
                    $stmt = $conn->prepare($sql);
                    
                    if (!$stmt) {
                        throw new Exception("Database error: " . $conn->error);
                    }

                    $stmt->bind_param("i", $id_article);
                    $stmt->execute();
                    foreach($categories as $id_category){
                        $sql = "INSERT INTO categoryArticles (id_category, id_article) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
        
                        if (!$stmt) {
                            throw new Exception("Database error: " . $conn->error);
                        }
        
                        $stmt->bind_param("ii", $id_category, $id_article);
                        $stmt->execute();
                    }
                }
            }
            
            $_SESSION['message'] = "Article Updated Successfully";

            $stmt->close();
            $conn->close();

            header("Location: ../../../pages/Articles/userArticles.php");
            exit;

        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }else{
        header("Location: ../../../pages/Articles/updateArticle.php");
        exit;
    }
}