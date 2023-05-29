<?php

// Récupération des données du formulaire
$email = $_POST['email'];
if (empty($email)) {
  $email = $_GET['email'];
}
$password = $_POST['password'];

// Connexion à la base de données
$servername = "localhost";
$username = "projetRecdevweb";
$password1 = "projetRecdevweb2023";
$dbname = "website_database";
try {
  $conn = new mysqli($servername, $username, $password1, $dbname);
} catch (Exception $e) {
  die("Connection failed: " . $e->getMessage());
}

// Vérification si l'email est déjà présent dans la base de données
$sql = "SELECT * FROM user WHERE mail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // L'email existe dans la base de données

  if (!empty($password)) {
    // Le champ du mot de passe a été soumis avec des données
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $update_sql = "UPDATE user SET password = ? WHERE mail = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();

    header('Location: login.php');
    exit();
  } else {
    // Le champ du mot de passe est vide
    header('Location: resetPassword.php?email=' . urlencode($email));
    exit();
  }
} else {
  // L'email n'existe pas dans la base de données
  header('Location: forgetPassword.php?success=2');
  exit();
}

?>
