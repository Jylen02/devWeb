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

// Vérification si l'ID de la recette est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    $idRecette = $_GET['id'];

    // Requête SQL pour récupérer tous les attributs de la recette
    $requeteRecette = "SELECT name, description, image FROM recipe WHERE id = $idRecette";
    $resultatRecette = mysqli_query($connexion, $requeteRecette);

    if (mysqli_num_rows($resultatRecette) > 0) {
        $rowRecette = mysqli_fetch_assoc($resultatRecette);
        $titre = $rowRecette['name'];
        $description = $rowRecette['description'];
        $image = $rowRecette['image'];

        // Affichage des détails de la recette
        //echo "<h3>$titre</h3>";
        //echo "<aside><p>$description</p></aside>";
        //echo "<header><img src='affichageImage.php?id=$idRecette' alt='$titre' width='200'></header>";
    } else {
        echo "Aucune recette trouvée.";
    }

    // Libération des résultats de la requête de la recette
    mysqli_free_result($resultatRecette);
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
</head>
<html>
    <body>
        <header>
            <?php
                echo "<h3>$titre</h3>";
                echo "<header><img src='affichageImage.php?id=$idRecette' alt='$titre' width='200'></header>";
                ?>
        </header>
        <aside>
            <?php
                echo "<aside><p>$description</p></aside>";
            ?>
        </aside>
    </body>
</html>