<?php


// Récupération des données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Connexion à la base de données
$servername = "localhost";
$username = "projetRecdevweb";
$password = "projetRecdevweb2023";
$dbname = "information_utilisateur";

$conn = new mysqli($servername, $username, $password, $dbname);
// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// vérifie si les données sont dans la base de donnée
$sql1 = "SELECT * FROM donnees_utilisateurs WHERE UserName = '$username'";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    $sql2 = "SELECT * FROM donnees_utilisateurs WHERE Password = '$password'";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0){
        // Échapper les caractères spéciaux pour la chaîne JavaScript
        $url = addslashes('home.php');

        // Afficher le script JavaScript pour ouvrir la nouvelle fenêtre
        echo "<script>window.open('$url', '_blank');</script>";

    }
    
} 
?>