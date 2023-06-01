<?php

// Récupération des données du formulaire

$username = $_POST['username'];
$password = $_POST['password'];

// Connexion à la base de données
include_once("../database.php");

// vérifie si les données sont dans la base de donnée
$queryUser = "SELECT * FROM user WHERE username = ? AND password = ?";
$stmt = $connexion->prepare($queryUser);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$resultUser = $stmt->get_result();
if ($resultUser->num_rows > 0) {
    // Authentification réussie, initialisation de la session
    session_start();

    // Stockage de l'identifiant de l'utilisateur dans la session
    $_SESSION['idUser'] = $username;

    header('Location: ../accueil/home.php');
    exit();
} else {
    header('Location: login.php?success=2');
    exit();
}
?>