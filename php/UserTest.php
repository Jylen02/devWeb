<?php
// Récupération des données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

// Connexion à la base de données
$servername = "%";
$username_db = "projetRecdevweb";
$password_db = "projetRecdevweb2023";
$dbname = "information_utilisateur";
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Construction de la requête SQL
$sql = "INSERT INTO donnees_utilisateurs (username, password, email) VALUES ('$username', '$password', '$email')";

// Exécution de la requête SQL
if ($conn->query($sql) === TRUE) {
  echo "Nouvelle ligne insérée avec succès.";
  
} else {
  echo "Erreur: " . $sql . "<br>" . $conn->error;
}

// Fermeture de la connexion à la base de données
$conn->close();
?>










// Récupération des données du formulaire
$email = $_POST['Email'];
$username = $_POST['UserName'];
$password = $_POST['Password'];

// Vérification si l'email est déjà présent dans la base de données
$servername = "localhost";

$username = "projetRecdevweb";

$password = "projetRecdevweb2023";

$dbname = "information_utilisateur";


$conn = new mysqli($servername, $username, $password, $dbname);
// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    //alert('la connexion au serveur à échouer');
  }
  
// Vérification si l'email est déjà présent dans la base de données
$sql = "SELECT * FROM donnees_utilisateurs WHERE Email = '$email'";
$result = $conn->query($sql);


//$sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";

$result = $conn->query($sql);
if($result){
  echo "Votre compte a été créé avec succès.";
} else {
  echo "Erreur lors de la création du compte : " . mysqli_error($conn);
}

// L'email n'existe pas encore dans la base de données, insertion des données du formulaire
//$sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";

if(!empty($email) && !empty($username) && !empty($password)){
    $sql = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";
    $result = $conn->query($sql);
  
    if($result){
      echo "Votre compte a été créé avec succès.";
    } else {
      echo "Erreur lors de la création du compte.";
    }
  }