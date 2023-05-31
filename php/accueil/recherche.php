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

    // Requête SQL pour récupérer le titre, la description et l'image de la recette correspondante dans la table "recette"
    $requeteRecette = "SELECT name, id, description, image FROM recipe WHERE name LIKE '%$recherche%'";
    $resultatRecette = mysqli_query($connexion, $requeteRecette);

    if (mysqli_num_rows($resultatRecette) > 0) {
        while ($rowRecette = mysqli_fetch_assoc($resultatRecette)) {
            $titre = $rowRecette['name'];
            $description = $rowRecette['description'];
            $image = $rowRecette['image'];
            $id = $rowRecette['id'];
            // Requête SQL pour calculer la moyenne des scores
            $requeteMoyenneScore = "SELECT AVG(evaluation.score) AS moyenne_score FROM evaluation JOIN recipe ON recipe.id = evaluation.idRecipe WHERE recipe.name LIKE '%$recherche%' AND recipe.id='$id'";
            $resultatMoyenneScore = mysqli_query($connexion, $requeteMoyenneScore);
            $rowMoyenneScore = mysqli_fetch_assoc($resultatMoyenneScore);
            $moyenneScore = round($rowMoyenneScore['moyenne_score']);
            $etoiles = str_repeat("*", $moyenneScore);

            // Affichage des résultats avec l'image
            //echo "<h3>$titre</h3>";
            //echo "<img src='$image' alt='$titre' width='200'>";
            //echo "<img src='affichageImage.php?id=$idRecette' alt='image n'a pas chargé !' width='200' > ";
            //echo "<p>$description</p>";
            echo "<h2><a href='../recette/detailsRecette.php?id=$id'>$titre</a>
                    <a href='../recette/scoreRecette.php?id=$id' style='color: red;'>$etoiles</a></h2><br> ";
            
            //echo "<a href='scoreRecette.php?id=$id' >$moyenneScore</a><br>";
            echo "<hr>";
        }
        
    } else {
        echo "Aucun résultat trouvé pour le mot-clé '$recherche'.";
    }

    // Libération des résultats de la requête de la recette
    mysqli_free_result($resultatRecette);
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
