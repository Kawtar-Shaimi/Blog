<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<div class="sidebar w-64 bg-blue-600 text-white p-6">
    <h2 class="text-2xl font-semibold mb-6">Admin Dashboard</h2>
    <ul>
        <li><a href="http://localhost/blog/pages/Admin/Users/afficherUsers.php" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Utilisateurs</a></li>
        <li><a href="http://localhost/blog/pages/Admin/Users/afficherAdmins.php" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Administrateurs</a></li>
        <li><a href="http://localhost/blog/pages/Admin/Articles/afficherArticles.php" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Articles</a></li>
        <li><a href="http://localhost/blog/pages/Admin/Categories/afficherCategories.php" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Categories</a></li>
        <li><a href="http://localhost/blog/pages/Admin/Comments/afficherComments.php" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Comments</a></li>
        <li>
            <form class="w-full" action="http://localhost/blog/Controllers/Frontoffice/Auth/logout.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"] ?>">
                <button class="w-full text-left block py-2 px-4 hover:bg-gray-700 rounded-lg">Logout</button>
            </form>
        </li>
    </ul>
</div>