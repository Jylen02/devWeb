<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération de l'ID de la recette
$idRecipe = $_POST['idRecipe'];

// Récupération des données de la ligne à copier
$queryRecipeProcess = "SELECT name, description, image, idUser, fornumber, time, difficulty, price FROM recipeinprocess WHERE id = ?";
$stmtRecipeProcess = $connexion->prepare($queryRecipeProcess);
$stmtRecipeProcess->bind_param("s", $idRecipe);
$stmtRecipeProcess->execute();
$resultRecipeProcess = $stmtRecipeProcess->get_result();

if ($resultRecipeProcess->num_rows > 0) {
    // Copie de la ligne dans la table de destination
    $row = $resultRecipeProcess->fetch_assoc();
    $insertRecipe = "INSERT INTO recipe (name, description, image, idUser, price, fornumber, time, difficulty) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtRecipe = $connexion->prepare($insertRecipe);
    $stmtRecipe->bind_param("ssbsssss", $row['name'], $row['description'], $row['image'], $row['idUser'], $row['price'], $row['fornumber'], $row['time'], $row['difficulty']);
    $stmtRecipe->execute();
    
    if ($stmtRecipe) {
        echo "La ligne a été copiée avec succès.";
      
        // Suppression de la ligne dans la table recipeinprocess
        $deleteRecipeProcess = "DELETE FROM recipeinprocess WHERE id = ?";
        $stmtDelete = $connexion->prepare($deleteRecipeProcess);
        $stmtDelete->bind_param('s', $idRecipe);
        $stmtDelete->execute();
    } else {
        echo "Une erreur s'est produite lors de la copie de la ligne : " . mysqli_error($connexion);
    }
} else {
    echo "Aucune ligne trouvée dans la table source avec l'ID spécifié.";
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>
