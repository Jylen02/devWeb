<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération du nouveau prix depuis la requête AJAX
$newPrice = $_POST["newPrice"];
$name = $_POST["name"];

if (!empty($newPrice)) {

    $updatePrice = "UPDATE productList SET price = ? WHERE name = ?";
    $stmt = $connexion->prepare($updatePrice);
    $stmt->bind_param("ss", $newPrice, $name);
    $stmt->execute();
    $resultPrice = $stmt;
    if ($resultPrice->affected_rows > 0) {
        echo "Le prix a été modifié avec succès !";
    } else {
        http_response_code(500); // Code d'erreur interne du serveur
        echo "Une erreur s'est produite lors de la modification du prix.";
    }
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>