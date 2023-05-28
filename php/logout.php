<?php
// Démarre la session
session_start();

// Détruit toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige vers la page de connexion ou la page d'accueil
header('Location: home.php'); // Remplacez login.php par votre page de connexion
exit();
?>
