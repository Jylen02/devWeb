<?php

// Connexion à la base de données
include_once("../database.php");

// Récupération du nouveau prix depuis la requête AJAX
$name = $_POST["name"];

if (!empty($name)) {
    $queryidRecipes = "SELECT idRecipe FROM product WHERE name = ?";
    $stmtidRecipes = $connexion->prepare($queryidRecipes);
    $stmtidRecipes->bind_param("s", $name);
    $stmtidRecipes->execute();
    $resultidRecipes = $stmtidRecipes->get_result();

    if ($resultidRecipes && $resultidRecipes->num_rows > 0) {
        while ($row = $resultidRecipes->fetch_assoc()) {
            $idRecipe = $row['idRecipe'];
            $updatePriceRecipe = "UPDATE recipe 
                SET price = ( 
                        SELECT SUM(productlist.price * product.amount) 
                        FROM product 
                        JOIN productlist ON productlist.name = product.name 
                        WHERE product.idRecipe = ? 
                    ) 
                WHERE id = ?";
            $stmtPriceRecipe = $connexion->prepare($updatePriceRecipe);
            $stmtPriceRecipe->bind_param("ss", $idRecipe, $idRecipe);
            $stmtPriceRecipe->execute();
            if ($stmtPriceRecipe->affected_rows > 0) {
                echo "Le prix a été modifié avec succès pour la recette d'ID $idRecipe !";
            } else {
                http_response_code(500); // Code d'erreur interne du serveur
                echo "Une erreur s'est produite lors de la modification du prix pour la recette d'ID $idRecipe.";
            }
        }
    }    
}
// Fermeture de la connexion à la base de données
$connexion->close();
?>