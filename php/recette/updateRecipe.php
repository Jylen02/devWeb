<?php
$response = array();

// Récupération des données du formulaire
$idRecette = $_POST['id'];
$fieldName = $_POST['field'];
$newValue = $_POST['value'];

// Connexion à la base de données
include_once("../database.php");
    session_start();

// Construction de la requête de mise à jour
$sql = "UPDATE recipeinprocess SET {$fieldName} = :newValue WHERE id = :idRecette";
$result = $connexion->query($sql);
$stmt = $sql->prepare($sql);
$stmt->bindParam(':newValue', $newValue);
$stmt->bindParam(':idRecette', $idRecette);

// Exécution de la requête de mise à jour
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Le changement a été enregistré avec succès!';
} else {
    $response['success'] = false;
    $response['message'] = 'Le changement n\'a pas pu être effectué';
}

// Envoi de la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
