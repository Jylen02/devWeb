<?php
session_start();
// Récupération des données du formulaire
if (isset($_SESSION['mail'])) {
  $email = $_SESSION['mail'];
} else {
  $email = $_POST['email'];
}
$password = $_POST['password'];

// Connexion à la base de données
include_once("../database.php");

// Vérification si l'email est déjà présent dans la base de données
$queryEmail = "SELECT COUNT(*) AS n FROM user WHERE mail = ?";
$stmt = $connexion->prepare($queryEmail);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultEmail = $stmt->get_result();
$rowEmail = mysqli_fetch_assoc($resultEmail);
$numEmail = $rowEmail['n'];
if ($numEmail > 0) {
  // L'email existe dans la base de données
  $_SESSION['mail'] = $email;
  if (!empty($password)) {
    // Le champ du mot de passe a été soumis avec des données
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $updatePassword = "UPDATE user SET password = ? WHERE mail = ?";
    $stmt = $connexion->prepare($updatePassword);
    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();
    session_destroy();
    header('Location: login.php');
    exit();
  } else {
    // Le champ du mot de passe est vide
    header('Location: forgetPassword.php?success=1');
    exit();
  }
} else {
  // L'email n'existe pas dans la base de données
  session_unset();
  header("Location: forgetPassword.php?success=2");
  exit();
}

?>