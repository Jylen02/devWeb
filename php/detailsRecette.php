<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "projetRecdevweb";
$motDePasse = "projetRecdevweb2023";
$baseDeDonnees = "information_utilisateur";

$connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérification de la connexion à la base de données
if (!$connexion) {
    die("Connexion à la base de données échouée : " . mysqli_connect_error());
}

// Vérification si l'ID de la recette est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    $idRecette = $_GET['id'];

    // Requête SQL pour récupérer tous les attributs de la recette
    $requeteRecette = "SELECT titre, description, image FROM recette WHERE id = $idRecette";
    $resultatRecette = mysqli_query($connexion, $requeteRecette);

    if (mysqli_num_rows($resultatRecette) > 0) {
        $rowRecette = mysqli_fetch_assoc($resultatRecette);
        $titre = $rowRecette['titre'];
        $description = $rowRecette['description'];
        $image = $rowRecette['image'];

        // Affichage des détails de la recette
        echo "<h3>$titre</h3>";
        echo "<p>$description</p>";
        echo "<img src='affichageImage.php?id=$idRecette' alt='$titre' width='200'>";
    } else {
        echo "Aucune recette trouvée.";
    }

    // Libération des résultats de la requête de la recette
    mysqli_free_result($resultatRecette);
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
