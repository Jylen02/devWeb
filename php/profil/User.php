<?php

// Connexion à la base de données
include_once("../database.php");

// Récupération des données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Vérification si l'email est déjà présent dans la base de données
$queryEmail = "SELECT * FROM user WHERE mail = ?";
$stmt = $connexion->prepare($queryEmail);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultEmail = $stmt->get_result();

// Vérification si le nom d'utilisateur est déjà présent dans la base de données

$queryUsername = "SELECT * FROM user WHERE username = ?";
$stmt = $connexion->prepare($queryUsername);
$stmt->bind_param("s", $username);
$stmt->execute();
$resultUsername = $stmt->get_result();

// Si l'email est déjà présent dans la base de données, afficher un message d'erreur
if ($resultEmail->num_rows > 0) {
    header('Location: createAccount.php?success=1');
    exit();
}
// Si le nom d'utilisateur est déjà présent dans la base de données, afficher un message d'erreur
else if ($resultUsername->num_rows > 0) {
    header('Location: createAccount.php?success=2');
    exit();
} else {
    // L'email n'existe pas encore dans la base de données, insertion des données du formulaire
    $insertUser = "INSERT INTO user (username, mail, password, enableComment) VALUES ( ?, ?, ?, '1')";
    $stmt = $connexion->prepare($insertUser);
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    $resultUser = $stmt;
    if ($resultUser) {
        header('Location: login.php?success=1');
        exit();
    } else {
        header('Location: createAccount.php?success=0&error =' . mysqli_error($connexion));
        exit();
    }
}
?>