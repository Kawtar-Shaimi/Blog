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

$sql= "SELECT * From comments";
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
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des categories</h2>
            
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Id Comment</th>
                            <th class="py-3 px-7 text-left text-sm font-medium text-gray-600">Content</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Id User</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Id Article</th>
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
                                    echo "<td class='py-3 px-4 text-sm text-gray-800'> {$row['id_comment']} </td>";
                                    echo "<td class='py-3 px-7 text-sm text-gray-800'> {$row['content']} </td>";
                                    echo "<td class='py-3 px-4 text-sm text-gray-800'> {$row['id_user']} </td>";
                                    echo "<td class='py-3 px-4 text-sm text-gray-800'> {$row['id_article']} </td>";
                                    echo "<td class='flex gap-2 px-2 py-2'>
                                            <form action='../../../Controllers/Backoffice/Comments/deleteComment.php' method='POST'>
                                                <input type='hidden' name='csrf_token' value='". htmlspecialchars($_SESSION['csrf_token']) . "'>
                                                <input type='hidden' value='". htmlspecialchars($row["id_comment"]) . "' name='id_comment'>
                                                <button type='submit' class='text-red-500 hover:text-red-700 cursor-pointer'>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-2'>No comments found</td></tr>";
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
