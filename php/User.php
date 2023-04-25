<?php


// Récupération des données du formulaire
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Connexion à la base de données
$servername = "localhost";
$username1 = "projetRecdevweb";
$password1 = "projetRecdevweb2023";
$dbname = "information_utilisateur";
try {
  $conn = new mysqli($servername, $username1, $password1, $dbname);
} catch (Exception $e) {
  die("Connection failed: " . $e->getMessage());
  echo "connection non etablie";
}


// Vérification de la connexion
/*if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}*/



// Vérification si l'email est déjà présent dans la base de données
$sql = "SELECT * FROM donnees_utilisateurs WHERE Email = '$email'";
$result = $conn->query($sql);
// Vérification si l'id est déjà présent dans la base de données
$sql1 = "SELECT * FROM donnees_utilisateurs WHERE UserName = '$username'";
$result1 = $conn->query($sql1);

// Si l'email est déjà présent dans la base de données, afficher un message d'erreur
if ($result->num_rows > 0) {
    echo "Cet email est déjà utilisé.";
} 
// Si l'email est déjà présent dans la base de données, afficher un message d'erreur
else if ($result1->num_rows > 0) {
  echo "Ce username est déjà utilisé.";
} 
else {
    // L'email n'existe pas encore dans la base de données, insertion des données du formulaire
    $sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";

    if(!empty($email) && !empty($username) && !empty($password)){
        $result = $conn->query($sql);

        if($result){
          echo "Votre compte a été créé avec succès.";
          
        } else {
          echo "Erreur lors de la création du compte : " . mysqli_error($conn);
        }
      }
    }

?>
