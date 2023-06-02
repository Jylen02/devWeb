<?php
// Récupération de l'ID de la recette
$idRecette = $_POST['id'];

include_once("../database.php");
session_start();

// Copie des données vers la table recipe
$sqlCopy = "INSERT INTO r recipe (idUser, name, description, image, fornumber, time, difficulty)
            SELECT idUser, name, description, image, fornumber, time, difficulty
            FROM recipeinprocess
            WHERE r.id = :idRecette";
$stmtCopy = $connexion->prepare($sqlCopy);
$stmtCopy->bindParam(':idRecette', $idRecette);
$stmtCopy->execute();

// Suppression de la ligne dans la table recipeinprocess
$sqlDelete = "DELETE FROM recipeinprocess WHERE id = :idRecette";
$stmtDelete = $connexion->prepare($sqlDelete);
$stmtDelete->bindParam(':idRecette', $idRecette);
$stmtDelete->execute();

echo "<script>alert('Upload confirmé avec succès');</script>";
?>
