<?php
    session_start();
    require "../../DB/database.php";

    $sql= "SELECT * From Users";
    $result = $conn->query($sql);

  

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


        <div class="sidebar w-64 bg-blue-600 text-white p-6">
            <h2 class="text-2xl font-semibold mb-6">Admin Dashboard</h2>
            <ul>
                <li><a href="backOffice.html" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Tableau de bord</a></li>
                <li><a href="afficherUsers.php" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Utilisateurs</a></li>
                <li><a href="afficherArticles.php" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Articles</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Paramètres</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700 rounded-lg">Déconnexion</a></li>
            </ul>
        </div>

        <div class="flex-1 p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">


                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Utilisateurs</h3>
                        <p class="text-2xl font-bold text-blue-600">1,250</p>
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
                        <p class="text-2xl font-bold text-green-600">50</p>
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
                        <p class="text-2xl font-bold text-yellow-600">350</p>
                    </div>
                    <div class="p-4 bg-yellow-100 rounded-full text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5"></path>
                        </svg>
                    </div>
                </div>

            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des utilisateurs</h2>
            
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-600">Id user</th>
                            <th class="py-3 px-7 text-left text-sm font-medium text-gray-600">Nom</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Email</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Password</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Role</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='border-b'>";
                                    echo "<td class='py-3 px-4 text-sm text-gray-800'> {$row['id_user']} </td>";
                                    echo "<td class='py-3 px-7 text-sm text-gray-800'> {$row['nom']} </td>";
                                    echo "<td class='py-3 px-6 text-sm text-gray-800'> {$row['email']}</td>";
                                    echo "<td class='py-3 px-6 text-sm text-gray-800'>{$row['password']}</td>";
                                    echo "<td class='py-3 px-6 text-sm text-gray-800'>{$row['role']}</td>";
                                    echo "<td class='flex gap-2 px-2 py-2'>
                                            <a class='text-blue-500 hover:text-blue-700' href='../../Controllers/Users/updateUser.php?id= {$row['id_user']} '>
                                                Modifier
                                            </a>
                                            <a class='text-red-500 hover:text-red-700 ml-2' href='../../Controllers/Users/deleteUser.php?id= {$row['id_user']} '>
                                                Supprimer
                                            </a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-2'>No clients found</td></tr>";
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
