<?php
    require "../../DB/database.php";

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $id_article = (int)$_GET['id'];

        try {
            $sql = "SELECT * FROM articles where id_article = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_article);
            $stmt->execute();
            $result = $stmt->get_result();
            $article_infos = $result->fetch_assoc();
            $sql = "SELECT category_name FROM categories
                    INNER JOIN categoryArticles
                    ON categories.id_category = categoryarticles.id_category
                    where categoryarticles.id_article = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_article);
            $stmt->execute();
            $categories = $stmt->get_result();
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article - SukiBlog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            
            <div class="text-2xl font-bold flex space-x-2">
                <a href="#">SukiBlog</a>
                <img class="w-10 h-8" src="../../images/noodles.png" alt="logo">
            </div>

            
            <nav>
                <ul class="flex space-x-6">
                    <li><a href="../../index.html" class="hover:text-gray-300">Home</a></li>
                    <li><a href="../Articles/afficherArticles.php" class="hover:text-gray-300">Articles</a></li>
                    <li><a href="#" class="hover:text-gray-300">Contact</a></li>
                    <li><a href="../../about" class="hover:text-gray-300">About Us</a></li>
                </ul>
            </nav>

            <div class="space-x-4">
                <a href="login.php" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">Login</a>
                <a href="signup.php" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">Sign Up</a>
            </div>
        </div>
    </header>


    <div class="container mx-auto py-8 px-4">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-xl">


            <article>
                <h1 class="text-4xl font-bold text-gray-800 mb-4"><?php echo $article_infos["titre"] ?></h1>
                <p class="text-sm text-gray-600 mb-4">Publié le 17 décembre 2024 par Auteur</p>
                <img class="w-full h-[700PX] object-cover rounded-lg mb-6" src="../.<?php echo $article_infos["img"] ?>" alt="image article">
                <p class="text-lg text-gray-700 mb-6"><?php echo $article_infos["content"] ?></p>
            </article>

            <ul class="list-disc my-10">
                Categories
                <?php
                if ($categories->num_rows > 0) {
                    while ($row = $categories->fetch_assoc()) {
                        echo "
                            <li>{$row["category_name"]}</li>
                        ";
                    }
                }
                ?>
            </ul>


            <div class="flex justify-between items-center mb-6">
                <button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    J'aime
                </button>
                <span class="text-gray-600">25 personnes aiment cet article</span>
            </div>


            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Commentaires</h2>


                <form action="#" method="POST" class="mb-6">
                    <textarea class="w-full p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out" rows="4" placeholder="Écrivez votre commentaire..." required></textarea>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 mt-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        Publier le commentaire
                    </button>
                </form>


                <div class="border-t border-gray-200 pt-4">
                    <div class="mb-6">
                        <p class="font-semibold text-gray-800">Kawtar Shaimi</p>
                        <p class="text-gray-600">J'ai trop aimée !</p>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 KSBlog. Tous droits réservés.</p>
        </div>
    </footer>

</body>

</html>