<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include_once("../Head.php");
    include_once("../database.php");
    session_start();
    if (isset($_GET['username']) && isset($_GET['enableComment'])) {
        $username = $_GET['username'];
        $enableComment = $_GET['enableComment'];
        $updateComment = "UPDATE user SET enableComment = '$enableComment' WHERE username = '$username'";
        $resultUpdate = $connexion->query($updateComment);

        if ($resultUpdate) {
            if ($enableComment == 1){
                echo "<script>alert('$username peut désormais évaluer des recettes.');</script>";
            } else {
                echo "<script>alert('$username ne peut plus évaluer de recettes.');</script>";
            }
        } else {
            echo "<script>alert('Erreur lors de l\'actualisation des permissions de commenter une recette.');</script>";
        }
    }
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <script> var username = "<?php echo isset($_SESSION['idUser']) ? $_SESSION['idUser'] : ''; ?>"; </script>

</head>

<body>
    <h1>Liste des utilisateurs</h1>

    <?php
    // Récupérer les données de la table productList
    $requeteUser = "SELECT username, enableComment FROM user";
    $result = $connexion->query($requeteUser);

    if ($result->num_rows > 0) {
        // Afficher le tableau si des données sont disponibles
        echo "<table>
         <tr>
             <th>Utilisateur</th>
             <th>Activer/Desactiver Commentaire</th>
         </tr>";

        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $enableComment = $row['enableComment'];

            echo "<tr>
             <td>$username</td>
             <td>
                 <a href=\"userList.php?username=$username&enableComment=" . ($enableComment == 1 ? 0 : 1) . "\">" . ($enableComment == 1 ? "Desactiver" : "Activer") . "</a>
             </td>
         </tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun utilisateur trouvé.";
    }
    ?>
    <div>
        <a href="../accueil/home.php" id="retourAccueil">
            ← Accueil
        </a>
    </div>
</body>

</html>