<?php
// Récupération des données du formulaire
$idRecette = $_POST['id'];
$fieldName = $_POST['field'];
$newValue = $_POST['value'];

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");

// Construction de la requête de mise à jour
$sql = "UPDATE recipeinprocess SET {$fieldName} = :$newValue WHERE id = :idRecette";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':newValue', $newValue);
$stmt->bindParam(':idRecette', $idRecette);

// Exécution de la requête de mise à jour
if ($stmt->execute()) {
    echo "La valeur a été mise à jour avec succès.";
} else {
    echo "Une erreur s'est produite lors de la mise à jour de la valeur.";
}
?>