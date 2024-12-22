<?php

$userId = $_COOKIE['user_id'] ?? null;
$userRole = $_COOKIE['user_role'] ?? null;

?>

<header class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        
        <div class="text-2xl font-bold flex space-x-2">
            <a href="http://localhost/blog">SukiBlog</a>
            <img class="w-10 h-8" src="http://localhost/blog/images/noodles.png" alt="logo">
        </div>

        <nav>
            <ul class="flex space-x-6">
                <li><a href="http://localhost/blog" class="hover:text-gray-300">Home</a></li>
                <li><a href="http://localhost/blog/pages/Articles/afficherArticles.php" class="hover:text-gray-300">Articles</a></li>
                <?php
                if($userId && $userRole == 'user'){
                    echo "
                        <li><a href='http://localhost/blog/pages/Articles/userArticles.php' class='hover:text-gray-300'>My Articles</a></li>
                    ";
                } 
                ?>
                <li><a href="#" class="hover:text-gray-300">Contact</a></li>
                <li><a href="http://localhost/blog/about.php" class="hover:text-gray-300">About Us</a></li>
            </ul>
        </nav>

        <?php 
        if(!$userId){
            echo "
                <div class='space-x-4'>
                    <a href='http://localhost/blog/pages/Auth/login.php' class='bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white py-2 px-4 rounded-lg transition duration-300'>Login</a>
                    <a href='http://localhost/blog/pages/Auth/signup.php' class='bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-300'>Sign Up</a>
                </div>
            ";
        }else{
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            echo "
                <form action='http://localhost/blog/Controllers/Frontoffice/Auth/logout.php' method='POST'>
                    <input type='hidden' name='csrf_token' value='{$_SESSION["csrf_token"]}'>
                    <button class='bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white py-2 px-4 rounded-lg transition duration-300'>Logout</button>
                </form>
            ";
        }
        ?>
        
    </div>
</header>