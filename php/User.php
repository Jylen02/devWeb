<?php

// Récupération des données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Vérification si l'email est déjà présent dans la base de données
$servername = "%";
$filename = "../sql/donnees_utilisateurs.sql";
$file_content = file_get_contents($filename);
$regex = "/INSERT INTO utilisateur \(email, username, password\) VALUES \('(.+)', '(.+)', '(.+)'\);/U";
$matches = [];
preg_match_all($regex, $file_content, $matches, PREG_SET_ORDER);

$username = "projetRecdevweb";

$password = "projetRecdevweb2023";

$dbname = "information_utilisateur";


$conn = new mysqli($servername, $username, $password, $dbname);
// Vérification si l'email est déjà présent dans la base de données
$sql = "SELECT * FROM donnees_utilisateurs WHERE Email = '$email'";
$result = $conn->query($sql);


$sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";

$result = $conn->query($sql);
// L'email n'existe pas encore dans la base de données, insertion des données du formulaire
$sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";

if(!empty($email) && !empty($username) && !empty($password)){
    $sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";
    $result = $conn->query($sql);
  
    if($result){
      echo "Votre compte a été créé avec succès.";
    } else {
      echo "Erreur lors de la création du compte.";
    }
  }
  

//Vérification des identifiants / mot de passe pour login

?>
