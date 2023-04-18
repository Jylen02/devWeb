<?php
// Récupération des données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Vérification si l'email est déjà présent dans la base de données
$servername = "%";

$username = "projetRecdevweb";

$password = "projetRecdevweb2023";

$dbname = "information_utilisateur";


$conn = new mysqli($servername, $username, $password, $dbname);
// Vérification si l'email est déjà présent dans la base de données
$sql = "SELECT * FROM donnees_utilisateurs WHERE Email = '$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // L'email existe déjà dans la base de données, affichage d'un message d'erreur
    echo "L'email est déjà utilisé, veuillez en choisir un autre.";
    exit;
}

$sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";

$result = $conn->query($sql);
// L'email n'existe pas encore dans la base de données, insertion des données du formulaire
$sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";

if (file_put_contents($filename, $new_line, FILE_APPEND)) {
    // Succès de l'insertion des données
    echo "Votre compte a été créé avec succès.";
} else {
    // Erreur lors de l'insertion des données
    echo "Erreur lors de la création du compte.";
}
?>
