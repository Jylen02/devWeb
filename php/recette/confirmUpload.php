<?php
// Récupération de l'ID de la recette
$idRecette = $_POST['id'];

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");

// Copie des données vers la table recipe
$sqlCopy = "INSERT INTO recipe (idUser, name, description, image, fornumber, time, difficulty)
            SELECT idUser, name, description, image, fornumber, time, difficulty
            FROM recipeinprocess
            WHERE id = :idRecette";
$stmtCopy = $pdo->prepare($sqlCopy);
$stmtCopy->bindParam(':idRecette', $idRecette);
$stmtCopy->execute();

// Suppression de la ligne dans la table recipeinprocess
$sqlDelete = "DELETE FROM recipeinprocess WHERE id = :idRecette";
$stmtDelete = $pdo->prepare($sqlDelete);
$stmtDelete->bindParam(':idRecette', $idRecette);
$stmtDelete->execute();
?>