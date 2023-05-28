<!DOCTYPE html>
<html lang="fr">  
<head>
    <?php
        include_once("Head.php");
    ?>
    <link rel="stylesheet"
    type="text/css"
    href="../css/home.css">
    <script src="../js/home.js" type="text/javascript">
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires de la recette</title>
</head>
<body>
    <h1>Commentaires de la recette</h1>

    <?php
    // Connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "projetRecdevweb";
    $motDePasse = "projetRecdevweb2023";
    $baseDeDonnees = "website_database";

    $connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

    // Vérification de la connexion à la base de données
    if (!$connexion) {
        die("Connexion à la base de données échouée : " . mysqli_connect_error());
    }

    // Récupération de l'ID de la recette depuis l'URL
    if (isset($_GET['id'])) {
        $idRecette = $_GET['id'];

        // Requête SQL pour récupérer les commentaires associés à l'ID de la recette
        $requeteCommentaires = "SELECT c.comment, u.username
                                FROM evaluation AS c
                                INNER JOIN user AS u ON c.idUser = u.username
                                WHERE c.idRecipe = $idRecette";
        $resultatCommentaires = mysqli_query($connexion, $requeteCommentaires);

        if (mysqli_num_rows($resultatCommentaires) > 0) {
            // Affichage des commentaires
            while ($rowCommentaire = mysqli_fetch_assoc($resultatCommentaires)) {
                $commentaire = $rowCommentaire['comment'];
                $utilisateur = $rowCommentaire['username'];

                echo "<p><strong>$utilisateur :</strong> $commentaire</p>";
            }
        } else {
            echo "<p>Aucun commentaire trouvé.</p>";
        }

        // Libération des résultats de la requête des commentaires
        mysqli_free_result($resultatCommentaires);
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($connexion);
    ?>
</body>
</html>
