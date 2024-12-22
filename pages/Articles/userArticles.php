<?php

if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role'])) {
    header("Location: ../../index.php");
}

session_start();
require "../../DB/database.php";

$userId = $_COOKIE['user_id'] ?? null;

$sql = "SELECT * FROM articles WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$userId);
$stmt->execute();
$articles = $stmt->get_result();

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles - KSBlog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

   
    <?php include_once "../../layouts/header.php";?>

    
    <section class="container mx-auto p-6 relative">
        <?php 
        if($message){
            echo "
                <div class='max-w-3xl mx-auto bg-green-600 rounded-lg my-5 py-5 ps-5'>
                    <p class='text-white font-bold'>$message</p>
                </div>
            ";
        }
        ?>
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">My Articles</h1>

            <a href="./ajouterArticle.php" class="absolute cursor-pointer top-7 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">Ajouter un article</a>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <?php
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            if ($articles->num_rows > 0) {
                while ($row = $articles->fetch_assoc()) {
                    echo "
                        <div class='bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300'>
                            <img src='../." . htmlspecialchars($row["img"]) . "' alt='Image Article 1' class='w-full h-48 object-cover'>
                            <div class='p-6'>
                                <h2 class='text-2xl font-semibold text-blue-600 mb-4'>" . htmlspecialchars($row["titre"]) . "</h2>
                                <p class='text-gray-700 mb-4'>". htmlspecialchars(substr($row["content"], 0, 200)) ."...</p>
                                <a href='./afficherArticle.php?id=" . htmlspecialchars($row["id_article"]) . "' class='text-blue-500 hover:underline font-semibold'>Lire la suite</a>
                            </div>
                            <div class='flex gap-2 px-2 py-2'>
                                <form action='../../Controllers/Frontoffice/Articles/getArticleInfo.php' method='POST'>
                                    <input type='hidden' name='csrf_token' value='". htmlspecialchars($_SESSION['csrf_token']) . "'>
                                    <input type='hidden' value='". htmlspecialchars($row["id_article"]) . "' name='id_article'>
                                    <button type='submit' class='text-blue-900 h-5 cursor-pointer'>
                                        <svg class='text-blue-900 h-5 cursor-pointer' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'>
                                            <path fill='currentColor' d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z'/>
                                        </svg>
                                    </button>
                                </form>
                                <form action='../../Controllers/Frontoffice/Articles/deleteArticle.php' method='POST'>
                                    <input type='hidden' name='csrf_token' value='". htmlspecialchars($_SESSION['csrf_token']) . "'>
                                    <input type='hidden' value='". htmlspecialchars($row["id_article"]) . "' name='id_article'>
                                    <button type='submit' class='text-blue-900 h-5 cursor-pointer'>
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='w-5 h-5'>
                                            <path fill='currentColor' d='M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z'/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    ";
                }
                $stmt->close();
                $conn->close();
            }
            ?>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 KSBlog. Tous droits réservés.</p>
        </div>
    </footer>

</body>

</html>