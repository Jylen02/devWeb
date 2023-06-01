<?php
// Récupération des données du formulaire
$idRecette = $_POST['id'];
$fieldName = $_POST['field'];
$newValue = $_POST['value'];

// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");

// Construction de la requête de mise à jour
$sql = "UPDATE recipeinprocess SET {$fieldName} = :newValue WHERE id = :idRecette";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':newValue', $newValue);
$stmt->bindParam(':idRecette', $idRecette);

// Exécution de la requête de mise à jour
if ($stmt->execute()) {
    echo "<script>alert('Le changement a été enregistré avec succès!');</script>";
} else {
    echo "<script>alert('Le changement n'a pas pu être effectué');</script>";
}
?>
