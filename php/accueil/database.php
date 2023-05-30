<?php

// Récupération des données du formulaire
$barreRecherche= $_POST['barreRecherche'];

// Connexion à la base de données
$servername = "localhost";
$username1 = "projetRecdevweb";
$password1 = "projetRecdevweb2023";
$dbname = "website_database";
try {
  $conn = new mysqli($servername, $username1, $password1, $dbname);
} catch (Exception $e) {
  die("Connection failed: " . $e->getMessage());
}

echo $barreRecherche;
?>
    
    