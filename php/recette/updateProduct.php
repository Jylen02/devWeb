<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération des données du formulaire
$idRecipe = $_POST['idRecipe'];
$name = $_POST['name'];
$newAmount = $_POST['newAmount'];

if (!empty($newAmount)) {
    // Construction de la requête SQL dynamiquement
    $updateAmount = "UPDATE product SET amount = ? WHERE idRecipe = ? AND name = ?";
    $stmt = $connexion->prepare($updateAmount);
    $stmt->bind_param("sss", $newAmount, $idRecipe, $name);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "La modification a été effectuée avec succès !";
    } else {
        http_response_code(500); // Code d'erreur interne du serveur
        echo "Une erreur s'est produite lors de la modification.";
    }
} else {
    echo "La nouvelle valeur est vide.";
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>