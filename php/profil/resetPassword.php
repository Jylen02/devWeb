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
$sql = "SELECT COUNT(*) AS n FROM user WHERE mail = ?";
$stmt = $connexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_assoc($result);
$n = $row['n'];
if ($n > 0) {
  // L'email existe dans la base de données
  $_SESSION['mail'] = $email;
  if (!empty($password)) {
    // Le champ du mot de passe a été soumis avec des données
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $update_sql = "UPDATE user SET password = ? WHERE mail = ?";
    $stmt = $connexion->prepare($update_sql);
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
  header("Location: forgetPassword.php?success=2");
  exit();
}

?>