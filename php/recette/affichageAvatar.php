<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "projetRecdevweb";
$motDePasse = "projetRecdevweb2023";
$baseDeDonnees = "website_database";

$connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

// Vérification de la connexion à la base de données
if (!$connexion) {
    die("Connexion à la base de données échouée : " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $username = $_GET['id'];

    $requete = "SELECT profilePictures FROM user WHERE username = '$username'";
    $resultat = mysqli_query($connexion, $requete);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        $row = mysqli_fetch_assoc($resultat);
        $imageData = $row['profilePictures'];

        header("Content-type: image/png"); // Remplacez par le type d'image approprié

        echo $imageData;
    }
}

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
