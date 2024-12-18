<?php 
    session_start();
    require "../../DB/database.php";

    $nameErr = $_SESSION["nameErr"] ?? null;
    $emailErr = $_SESSION["emailErr"] ?? null;
    $passErr = $_SESSION["passErr"] ?? null;
    $confirmPassErr = $_SESSION["confirmPassErr"] ?? null;
    unset($_SESSION["nameErr"],$_SESSION["emailErr"],$_SESSION["passErr"],$_SESSION["confirmPassErr"])
?>

<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
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
                    <li><a href="../Articles/afficherArticles.html" class="hover:text-gray-300">Articles</a></li>
                    <li><a href="#" class="hover:text-gray-300">Categories</a></li>
                    <li><a href="#" class="hover:text-gray-300">Contact</a></li>
                    <li><a href="#" class="hover:text-gray-300">About Us</a></li>
                </ul>
            </nav>

            
            <div class="space-x-4">
                <a href="login.html" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white py-2 px-4 rounded-lg transition duration-300">Login</a>
                <a href="signup.php" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300">Sign Up</a>
            </div>
        </div>
    </header>

   
    <div class="flex justify-center items-center min-h-screen">
    
        
        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-sm transform transition-all duration-300 hover:scale-105">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">S'inscrire</h2>
            
            <form action="../../Controllers/signUp.php" method="POST">
                
                <div class="mb-4">
                    <label for="fullname" class="block text-sm font-medium text-gray-600">Nom</label>
                    <input type="text"  name="nom" placeholder="Entrez votre nom complet" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105" >
                        <?php if($nameErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$nameErr</p><br>" ?>
                </div>

                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" name="email" placeholder="Entrez votre email" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105">
                    <?php if($emailErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$emailErr</p><br>" ?>
                </div>

                
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                    <input type="password"  name="password" placeholder="Entrez votre mot de passe" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105">
                    <?php if($passErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$passErr</p><br>" ?>
                </div>

                
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-600">Confirmez le mot de passe</label>
                    <input type="password"  name="confirm_password" placeholder="Confirmez votre mot de passe" class="mt-2 px-4 py-2 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300 ease-in-out transform hover:scale-105">
                    <?php if($confirmPassErr) echo "<p class='text-red-600 text-sm lg:text-[15px]'>$confirmPassErr</p><br>" ?>
                </div>

                
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:scale-105">
                    S'inscrire
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="login.html" class="text-sm text-blue-500 hover:underline transition duration-300 ease-in-out transform hover:scale-105">Déjà un compte ? Connectez-vous</a>
            </div>
        </div>

    </div>

</body>

</html>