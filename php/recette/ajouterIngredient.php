<?php
include_once("../database.php");

// Récupération des données depuis la requête AJAX
$nomIngredient = $_POST["name"];
$prixIngredient = $_POST["price"];

if (!empty($nomIngredient) && !empty($prixIngredient)) {
  $insertQuery = "INSERT INTO productList (name, price) VALUES (?, ?)";
  $stmt = $connexion->prepare($insertQuery);
  $stmt->bind_param("ss", $nomIngredient, $prixIngredient);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "L'ingrédient a bien été ajouté !";
  } else {
    http_response_code(500);
    echo "Une erreur s'est produite lors de l'ajout de l'ingrédient.";
  }
} else {
  echo "Une erreur s'est produite lors de l'ajout de l'ingrédient.";
}

$connexion->close();
?>
