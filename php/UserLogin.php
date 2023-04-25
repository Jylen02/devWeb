<?php


// Récupération des données du formulaire

$username = $_POST['username'];
$password = $_POST['password'];

// Connexion à la base de données
$servername = "localhost";
$username1 = "projetRecdevweb";
$password1 = "projetRecdevweb2023";
$dbname = "information_utilisateur";

$conn = new mysqli($servername, $username1, $password1, $dbname);
// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// vérifie si les données sont dans la base de donnée
$sql1 = "SELECT * FROM donnees_utilisateurs WHERE UserName = '$username' AND Password = '$password'";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    header('Location: home.php');
    exit();
    }
else{ 
    header('Location: login.php?success=2');
    exit();
}
?>