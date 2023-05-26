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

// Vérification si le formulaire de recherche est soumis
if (isset($_POST['recherche'])) {
    $recherche = $_POST['recherche'];

    // Requête SQL pour récupérer les idRecette correspondant au mot-clé dans la table "tag"
    $requete = "SELECT idRecipe FROM tag WHERE keyWord LIKE '%$recherche%'";
    $resultat = mysqli_query($connexion, $requete);

    if (mysqli_num_rows($resultat) > 0) {
        while ($row = mysqli_fetch_assoc($resultat)) {
            $idRecette = $row['idRecipe'];

            // Requête SQL pour récupérer le titre, la description et l'image de la recette correspondante dans la table "recette"
            $requeteRecette = "SELECT name, id, description, image FROM recipe WHERE id = $idRecette";
            $resultatRecette = mysqli_query($connexion, $requeteRecette);

            if (mysqli_num_rows($resultatRecette) > 0) {
                $rowRecette = mysqli_fetch_assoc($resultatRecette);
                $titre = $rowRecette['name'];
                $description = $rowRecette['description'];
                $image = $rowRecette['image'];
                $id = $rowRecette['id'];
                // Affichage des résultats avec l'image
                //echo "<h3>$titre</h3>";
                //echo "<img src='$image' alt='$titre' width='200'>";
                //echo "<img src='affichageImage.php?id=$idRecette' alt='image n'a pas chargé !' width='200' > ";
                //echo "<p>$description</p>";
                echo "<h2><a href='detailsRecette.php?id=$id'>$titre</a><h2><br>";
                echo "<hr>";
            }

            // Libération des résultats de la requête de la recette
            mysqli_free_result($resultatRecette);
        }
    } else {
        echo "Aucun résultat trouvé pour le mot-clé '$recherche'.";
    }

    // Libération des résultats de la requête des tags
    mysqli_free_result($resultat);
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
