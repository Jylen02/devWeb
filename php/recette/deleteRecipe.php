<?php
// Récupération de l'ID de la recette
$idRecette = $_POST['id'];

// Connexion à la base de données
include_once("../database.php");
    session_start();

// Suppression de la ligne dans la table recipeinprocess
$sql = "DELETE FROM recipeinprocess WHERE id = :idRecette";
$stmt = $connexion->prepare($sql);
$stmt->bindParam(':idRecette', $idRecette);
$stmt->execute();
?>