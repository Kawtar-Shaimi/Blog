<?php
if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_role'])) {
    header("Location: ../../../index.php");
}else{
    if ($_COOKIE['user_role'] != 'admin') {
        header("Location: ../../../index.php");
    }
} 

session_start();
require "../../../DB/database.php";

$sql= "SELECT * From articles";
$result = $conn->query($sql);

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">


        <?php include_once "../../../layouts/sidebar.php";?>

        <div class="flex-1 p-6">
            <?php include_once "../../../layouts/statics.php";?>

            <?php 
            if($message){
                echo "
                    <div class='max-w-3xl mx-auto bg-green-600 rounded-lg my-5 py-5 ps-5'>
                        <p class='text-white font-bold'>$message</p>
                    </div>
                ";
            }
            ?>

            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des articles</h2>
            
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Id article</th>
                            <th class="py-3 px-7 text-left text-sm font-medium text-gray-600">Titre</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Content</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Image</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Id user</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (empty($_SESSION['csrf_token'])) {
                                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                            }
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='border-b'>";
                                    echo "<td class='py-3 px-4 text-sm text-gray-800'> {$row['id_article']} </td>";
                                    echo "<td class='py-3 px-7 text-sm text-gray-800'> {$row['titre']} </td>";
                                    echo "<td class='py-3 px-6 text-sm text-gray-800'> {$row['content']}</td>";
                                    echo "<td class='py-3 px-6 text-sm text-gray-800'>{$row['img']}</td>";
                                    echo "<td class='py-3 px-6 text-sm text-gray-800'>{$row['id_user']}</td>";
                                    echo "<td class='flex gap-2 px-2 py-2'>
                                            <form action='../../../Controllers/Backoffice/Articles/getArticleInfo.php' method='POST'>
                                                <input type='hidden' name='csrf_token' value='". htmlspecialchars($_SESSION['csrf_token']) . "'>
                                                <input type='hidden' value='". htmlspecialchars($row["id_article"]) . "' name='id_article'>
                                                <button type='submit' class='text-blue-500 hover:text-blue-700 cursor-pointer'>
                                                    Modifier
                                                </button>
                                            </form>
                                            <form action='../../../Controllers/Backoffice/Articles/deleteArticle.php' method='POST'>
                                                <input type='hidden' name='csrf_token' value='". htmlspecialchars($_SESSION['csrf_token']) . "'>
                                                <input type='hidden' value='". htmlspecialchars($row["id_article"]) . "' name='id_article'>
                                                <button type='submit' class='text-red-500 hover:text-red-700 cursor-pointer'>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-2'>No articles found</td></tr>";
                            }
                            $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
