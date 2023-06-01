<?php
// Connexion à la base de données
include_once("../database.php");

// Récupération du nouveau prix depuis la requête AJAX
$name = $_POST["name"];

if (!empty($name)) {

    $deleteProduct = "DELETE FROM productlist WHERE name = ?";
    $stmt = $connexion->prepare($deleteProduct);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $resultPrice = $stmt;
    if ($resultPrice) {
        echo "L'ingrédient a bien été supprimer' !";
    } else {
        http_response_code(500); // Code d'erreur interne du serveur
        echo "Une erreur s'est produite lors de la suppression de l'ingrédient.";
    }
} else {
    echo "Une erreur s'est produite lors de la suppression de l'ingrédient.";
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>