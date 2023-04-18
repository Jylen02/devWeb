<?php
// Récupération des données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Vérification si l'email est déjà présent dans la base de données
$filename = "donnees_utilisateurs.sql";
$file_content = file_get_contents($filename);
$regex = "/INSERT INTO utilisateur \(email, username, password\) VALUES \('(.+)', '(.+)', '(.+)'\);/U";
$matches = [];
preg_match_all($regex, $file_content, $matches, PREG_SET_ORDER);

foreach ($matches as $match) {
    if ($match[1] == $email) {
        // L'email existe déjà dans la base de données, affichage d'un message d'erreur
        echo "L'email est déjà utilisé, veuillez en choisir un autre.";
        exit;
    }
}

// L'email n'existe pas encore dans la base de données, insertion des données du formulaire
$new_line = "INSERT INTO utilisateur (email, username, password) VALUES ('$email', '$username', '$password');\n";
if (file_put_contents($filename, $new_line, FILE_APPEND)) {
    // Succès de l'insertion des données
    echo "Votre compte a été créé avec succès.";
} else {
    // Erreur lors de l'insertion des données
    echo "Erreur lors de la création du compte.";
}
?>
