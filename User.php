<?php
// initialiser le tableau pour stocker les informations d'utilisateur
$utilisateurs = array();

// fonction pour ajouter un nouvel utilisateur
function ajouter_utilisateur() {
    
    global $utilisateurs;
    $username = $_POST["username"];
    $mdp= $_POST["password"];
    
    if (isset($utilisateurs[$username])){
        echo "Le nom d'utilisateur '$username' existe déjà. Veuillez en choisir un autre.";
        
    }
    else{
        $utilisateurs[$username] = $mdp;
    }
}

// fonction pour vérifier si un utilisateur existe dans le tableau
function verifier_utilisateur($username, $mdp) {
    global $utilisateurs;
    if (isset($utilisateurs[$username]) && $utilisateurs[$username] == $mdp) {
        header('Location: Home');
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect";
    }
}


?>

