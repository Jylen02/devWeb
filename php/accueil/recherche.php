<?php
// Connexion à la base de données
include_once("../database.php");

// Vérification si le formulaire de recherche est soumis
if (isset($_POST['recherche'])) {
    $recherche = $_POST['recherche'];

    // Requête SQL pour récupérer le titre, la description et l'image de la recette correspondante dans la table "recipe"
    $queryRecipe = "SELECT name, id, description, image FROM recipe WHERE name LIKE ? AND valid=1";
    $recherche = "%$recherche%";
    $stmt = $connexion->prepare($queryRecipe);
    $stmt->bind_param("s", $recherche);
    $stmt->execute();
    $resultRecipe = $stmt->get_result();

    if ($resultRecipe->num_rows > 0) {
        while ($rowRecette = mysqli_fetch_assoc($resultRecipe)) {
            $title = $rowRecette['name'];
            $description = $rowRecette['description'];
            $image = $rowRecette['image'];
            $id = $rowRecette['id'];

            // Requête SQL pour calculer la moyenne des scores
            $queryAverageScore = "SELECT AVG(evaluation.score) AS average_score FROM evaluation JOIN recipe ON recipe.id = evaluation.idRecipe WHERE recipe.name LIKE ? AND recipe.id = ?";
            $stmt = $connexion->prepare($queryAverageScore);
            $stmt->bind_param("ss", $recherche, $id);
            $stmt->execute();
            $resultAverageScore = $stmt->get_result();
            $rowAverageScore = mysqli_fetch_assoc($resultAverageScore);
            $averageScore = round($rowAverageScore['average_score']);
            $stars = str_repeat("*", $averageScore);

            // Affichage des résultats avec l'image
            echo "<br>";
            echo "<section class='info'>";
            //Affiche l'image de la recette
            echo "<section class='image'>";
            echo "<img src='../recette/affichageImage.php?id=$id' width='100'>";
            echo "</section>";
            echo "<section class='recette'>";
            echo "<h2><a href='../recette/detailsRecette.php?id=$id'>$title</a>
                                <a href='../recette/scoreRecette.php?id=$id' style='color: red;'>$stars</a></h2><br> ";
            echo "</section>";
            echo "</section>";
            echo "<hr>";
            mysqli_free_result($resultAverageScore);
        }

    } else {
        echo "Aucun résultat trouvé pour le mot-clé '$recherche'.";
    }

    // Libération des résultats de la requête de la recette
    mysqli_free_result($resultRecipe);
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>