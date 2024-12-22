<?php
    require "../../../DB/database.php";

    $usersSql= "SELECT COUNT(*) From users WHERE role = 'user'";
    $usersResult = $conn->query($usersSql);
    $usersCount = $usersResult->fetch_column();

    $adminsSql= "SELECT COUNT(*) From users WHERE role = 'admin'";
    $adminsResult = $conn->query($adminsSql);
    $adminsCount = $adminsResult->fetch_column();

    $articlesSql= "SELECT COUNT(*) From articles";
    $articlesResult = $conn->query($articlesSql);
    $articlesCount = $articlesResult->fetch_column();

    $categoriesSql= "SELECT COUNT(*) From categories";
    $categoriesResult = $conn->query($categoriesSql);
    $categoriesCount = $categoriesResult->fetch_column();

    $commentsSql= "SELECT COUNT(*) From comments";
    $commentsResult = $conn->query($commentsSql);
    $commentsCount = $commentsResult->fetch_column();
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Utilisateurs</h3>
            <p class="text-2xl font-bold text-blue-600"><?php echo $usersCount?></p>
        </div>
        <div class="p-4 bg-blue-100 rounded-full text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
            </svg>
        </div>
    </div>

    
    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Administrateurs</h3>
            <p class="text-2xl font-bold text-green-600"><?php echo $adminsCount?></p>
        </div>
        <div class="p-4 bg-green-100 rounded-full text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8"></path>
            </svg>
        </div>
    </div>


    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Articles</h3>
            <p class="text-2xl font-bold text-yellow-600"><?php echo $articlesCount?></p>
        </div>
        <div class="p-4 bg-yellow-100 rounded-full text-yellow-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
            </svg>
        </div>
    </div>


    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Comments</h3>
            <p class="text-2xl font-bold text-red-600"><?php echo $commentsCount?></p>
        </div>
        <div class="p-4 bg-red-100 rounded-full text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8"></path>
            </svg>
        </div>
    </div>


    <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Categories</h3>
            <p class="text-2xl font-bold text-purple-600"><?php echo $categoriesCount?></p>
        </div>
        <div class="p-4 bg-purple-100 rounded-full text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
            </svg>
        </div>
    </div>

</div>