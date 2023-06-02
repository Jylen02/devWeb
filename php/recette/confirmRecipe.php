<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération de l'ID de la recette
$idRecipe = $_POST['idRecipe'];

$updateValid = "UPDATE recipe SET valid=1";
$resultUpdate = $connexion->query($updateValid);
if ($resultUpdate) {
    echo "La confirmation a été effectuée avec succès !";
} else {
    http_response_code(500); // Code d'erreur interne du serveur
    echo "Une erreur s'est produite lors de la confirmation.";
}
// Fermeture de la connexion à la base de données
$connexion->close();
?>