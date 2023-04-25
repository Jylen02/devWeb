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
}


// Vérification de la connexion
/*if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}*/



// Vérification si l'email est déjà présent dans la base de données
$sql = "SELECT * FROM donnees_utilisateurs WHERE Email = '$email'";
$result = $conn->query($sql);

// Vérification si le nom d'utilisateur est déjà présent dans la base de données

$sql1 = "SELECT * FROM donnees_utilisateurs WHERE UserName = '$username'";
$result1 = $conn->query($sql1);

// Si l'email est déjà présent dans la base de données, afficher un message d'erreur
if ($result->num_rows > 0) {
    header('Location: createAccount.php?success=1');
    exit();
} 
// Si le nom d'utilisateur est déjà présent dans la base de données, afficher un message d'erreur
else if ($result1->num_rows >0){
    header('Location: createAccount.php?success=2');
    exit();
}

else {
    // L'email n'existe pas encore dans la base de données, insertion des données du formulaire
    $sql2 = "INSERT INTO donnees_utilisateurs (UserName, Password, Email) VALUES ('$username', '$password', '$email')";
    $result2 = $conn->query($sql2);
    if ($result2){
        header('Location: login.php?success=1');
        exit();
    }
    else {
        header('Location: createAccount.php?success=0&error =' . mysqli_error($conn));
        exit();
    }
}
?>
