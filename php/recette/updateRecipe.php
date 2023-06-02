<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération des données du formulaire
$idRecipe = $_POST['idRecipe'];
$key = $_POST['key'];
$newValue = $_POST['newValue'];

if (!empty($newValue)) {
    // Construction de la requête SQL dynamiquement
    $updateValue = "UPDATE recipeinprocess SET $key = ? WHERE id = ?";
    $stmt = $connexion->prepare($updateValue);
    $stmt->bind_param("ss", $newValue, $idRecipe);
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

