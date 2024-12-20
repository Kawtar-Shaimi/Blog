<?php
    session_start();
    require "../../DB/database.php";
    $emailErr = $_SESSION["emailErr"] ?? null;
    $passErr = $_SESSION["passErr"] ?? null;
    $loginErr = $_SESSION["loginErr"] ?? null;
    unset($_SESSION["emailErr"],$_SESSION["passErr"],$_SESSION["loginErr"]);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Login</title>
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
                    <li><a href="#" class="hover:text-gray-300">About Us</a></li>
                </ul>
            </nav>

            
            <div class="space-x-4">
                <a href="login.php" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">Login</a>
                <a href="signup.php" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">Sign Up</a>
            </div>
        </div>
    </header>

   
    <div class="flex justify-center items-center min-h-screen">

        
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-sm transform transition-all duration-300 hover:scale-105">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Se connecter</h2>
            
            <form action="../../Controllers/login.php" method="POST">
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" id="email" name="email" placeholder="Entrez votre email" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105" required>
                    <?php if($emailErr)echo "<p class='text-red-600 text-sm lg:text-[15px]'>$emailErr</p>" ?>
                </div>

                
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105" required>
                    <?php if($passErr)echo "<p class='text-red-600 text-sm lg:text-[15px]'>$passErr</p>" ?>
                </div>

                
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:scale-105">Se connecter</button>
                <?php if($loginErr)echo "<p class='text-red-600 text-sm lg:text-[15px]'>$loginErr</p>" ?>
            </form>

            <div class="text-center mt-4">
                <a href="#" class="text-sm text-blue-500 hover:underline transition duration-300 ease-in-out transform hover:scale-105">Mot de passe oublié ?</a>
            </div>
        </div>

    </div>

</body>

</html>
