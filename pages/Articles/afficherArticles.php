<?php
session_start();
require "../../DB/database.php";

$sql = "SELECT * FROM articles";
$articles = $conn->query($sql);

$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
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

   
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
           
            <div class="text-2xl font-bold flex space-x-2">
                <a href="#">KSBlog</a>
                <img class="w-10 h-8" src="../../images/noodles.png" alt="logo">
            </div>

            
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="../../index.html" class="hover:text-gray-300">Home</a></li>
                    <li><a href="../Articles/afficherArticles.php" class="hover:text-gray-300">Articles</a></li>
                    <li><a href="#" class="hover:text-gray-300">Contact</a></li>
                    <li><a href="../../about.html" class="hover:text-gray-300">About Us</a></li>
                </ul>
            </nav>

            
            <div class="space-x-4">
                <a href="../Auth/login.php" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">Login</a>
                <a href="../Auth/signup.php" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">Sign Up</a>
            </div>
        </div>
    </header>

    
    <section class="container mx-auto p-6 relative">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Les plus connus</h1>

            <a href="ajouterArticle.html" class="absolute cursor-pointer top-7 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">Ajouter un article</a>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <?php
            if ($articles->num_rows > 0) {
                while ($row = $articles->fetch_assoc()) {
                    echo "
                        <div class='bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300'>
                            <img src='../.{$row["img"]}' alt='Image Article 1' class='w-full h-48 object-cover'>
                            <div class='p-6'>
                                <h2 class='text-2xl font-semibold text-blue-600 mb-4'>{$row["titre"]}</h2>
                                <p class='text-gray-700 mb-4'>". substr($row["content"], 0, 200) ."...</p>
                                <a href='./afficherArticle.php?id={$row["id_article"]}' class='text-blue-500 hover:underline font-semibold'>Lire la suite</a>
                            </div>
                        </div>
                    ";
                }
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