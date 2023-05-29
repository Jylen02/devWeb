<?php


// Récupération des données du formulaire

$username = $_POST['username'];
$password = $_POST['password'];

// Connexion à la base de données
$servername = "localhost";
$username1 = "projetRecdevweb";
$password1 = "projetRecdevweb2023";
$dbname = "website_database";

$conn = new mysqli($servername, $username1, $password1, $dbname);
// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// vérifie si les données sont dans la base de donnée
$sql1 = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    // Authentification réussie, initialisation de la session
    session_start();
    
    // Stockage de l'identifiant de l'utilisateur dans la session
    $_SESSION['idUser'] = $username;
    
    header('Location: ../accueil/home.php?success=1');
    exit();
} else {
    header('Location: login.php?success=0');
    exit();
}
?>