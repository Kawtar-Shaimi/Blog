<?php 

if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role'])) {
    header("Location: ../../index.php");
}

session_start();
require "../../DB/database.php";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$sql = "SELECT * FROM categories";
$categories = $conn->query($sql);

$titleErr = $_SESSION["titleErr"] ?? null;
$contentErr = $_SESSION["contentErr"] ?? null;
$imgErr = $_SESSION["imgErr"] ?? null;
$categoriesErr = $_SESSION["categoriesErr"] ?? null;
unset($_SESSION["titleErr"],$_SESSION["contentErr"],$_SESSION["imgErr"],$_SESSION["categoriesErr"]);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Article</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 overflow-x-hidden">

    <?php include_once "../../layouts/header.php";?>


    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-xl">

            
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Ajouter un Article</h1>

         
            <form action="../../Controllers/Frontoffice/Articles/ajouterArticle.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'article</label>
                    <input type="text" id="title" name="titre" placeholder="Entrez le titre" required
                        class="mt-2 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <?php if($titleErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$titleErr</p><br>" ?>
                </div>

               
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Contenu de l'article</label>
                    <textarea id="content" name="content" rows="6" placeholder="Entrez le contenu ici" required
                        class="mt-2 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                    <?php if($contentErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$contentErr</p><br>" ?>
                </div>

                
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" accept=".png, .jpg, .jpeg, .webp" id="image" name="img" placeholder="Entrez le chemin de l'image" required 
                        class="mt-2 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <?php if($imgErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$imgErr</p><br>" ?>
                </div>

                                
                <div class="mb-6">
                    <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
                    <select multiple id="categories" name="categories[]" required class="mt-2 block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option>-- Choisire votre categories --</option>
                        <?php
                        if ($categories->num_rows > 0) {
                            while ($row = $categories->fetch_assoc()) {
                                echo "
                                    <option value='{$row["id_category"]}'>{$row["category_name"]}</option>
                                ";
                            }
                        }
                        ?>
                    </select>
                    <?php if($categoriesErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$categoriesErr</p><br>" ?>
                </div>

                
                <div class="text-center">
                    <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white font-medium text-lg rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Ajouter l'Article
                    </button>
                </div>
            </form>

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
