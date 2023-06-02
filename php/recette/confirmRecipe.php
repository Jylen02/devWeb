<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération de l'ID de la recette
$idRecipe = $_POST['idRecipe'];

$updateValid = "UPDATE recipe SET valid=1 WHERE id = ?";
$stmt = $connexion->prepare($updateValid);
$stmt->bind_param("s", $idRecipe);
$stmt->execute();
$resultUpdate = $stmt;
if ($resultUpdate->affected_rows > 0) {
    echo "La confirmation a été effectuée avec succès !";
} else {
    http_response_code(500); // Code d'erreur interne du serveur
    echo "Une erreur s'est produite lors de la confirmation.";
}
// Fermeture de la connexion à la base de données
$connexion->close();
?>