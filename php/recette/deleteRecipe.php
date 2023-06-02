<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération de l'ID de la recette
$idRecipe = $_POST['idRecipe'];

// Suppression de la ligne dans la table recipe
$deleteRecipe = "DELETE FROM recipe WHERE id = ?";
$stmtDeleteRecipe = $connexion->prepare($deleteRecipe);
$stmtDeleteRecipe->bind_param('s', $idRecipe);
$stmtDeleteRecipe->execute();
if ($stmtDeleteRecipe->affected_rows > 0) {
    $deleteProduct = "DELETE FROM product WHERE idRecipe = ?";
    $stmtDeleteProduct = $connexion->prepare($deleteProduct);
    $stmtDeleteProduct->bind_param('s', $idRecipe);
    $stmtDeleteProduct->execute();
    if ($stmtDeleteProduct->affected_rows > 0){
        echo "La suppression a été effectuée avec succès !";
    }else{
        http_response_code(500); // Code d'erreur interne du serveur
        echo "Une erreur s'est produite lors de la suppression.";
    }
} else {
    http_response_code(500); // Code d'erreur interne du serveur
    echo "Une erreur s'est produite lors de la suppression.";
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>