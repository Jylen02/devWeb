<?php
// Récupération de l'ID de la recette
$idRecette = $_POST['id'];

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");

// Suppression de la ligne dans la table recipeinprocess
$sql = "DELETE FROM recipeinprocess WHERE id = :idRecette";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':idRecette', $idRecette);
$stmt->execute();
?>