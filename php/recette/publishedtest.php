



<!DOCTYPE html>
<html lang="fr">  
<head>
    <?php
    include_once("../Head.php");
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/imageSetting.css">
    <script src="../../js/home.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une recette</title>
</head>
<body>
<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idUser'])) {
    header("Location: ../profil/login.php");
    exit;
}
// Vérification si l'utilisateur est l'administrateur
if ($_SESSION['idUser'] === 'admin') {
    // Rediriger l'administrateur vers la page de consultation des recettes
    header("Location: consulteRecipe.php");
    exit();
}
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $idUser = $_SESSION['idUser'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $fornumber = $_POST['fornumber'];
    $time = $_POST['time'];
    $difficulty = $_POST['difficulty'];

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['tmp_name'];

        // Copier l'image dans un répertoire de destination
        $destination = "chemin/vers/le/repertoire/de/destination/" . $_FILES['image']['name'];
        move_uploaded_file($image, $destination);
    } else {
        $image = null;
    }

    // Connexion à la base de données et insertion des données dans la table "recipeinprocess"
    $pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");
    $sql = "INSERT INTO recipeinprocess (idUser, name, description, image, fornumber, time, difficulty) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$idUser, $name, $description, $image, $fornumber, $time, $difficulty]);

    if ($stmt->rowCount() > 0) {
        // Succès de l'enregistrement
        echo "<script>alert('La publication s'est faite avec succès!');</script>";
        // Redirection vers une page de confirmation ou une autre action souhaitée
        if (isset($_SESSION['idUser'])) {
            echo "<script>window.location.href = '../accueil/home.php?success=1';</script>";
        } else {
            echo "<script>window.location.href = '../accueil/home.php?success=0';</script>";
        }
    } else {
        // Erreur lors de l'enregistrement
        echo "<script>alert('Une erreur est survenue lors de l'enregistrement de la publication. Veuillez réessayer.');</script>";
    }

    exit;

}
?>

<header>
        <div id="top">
            <?php
            // Vérification si l'utilisateur est connecté
            if (isset($_SESSION['idUser'])) {
                // Afficher le bouton "Déconnexion" et le lien vers le profil
                echo '<a class="Connexion" href="../profil/logout.php">Déconnexion</a>';
                echo '<a class="Connexion" href="../profil/settings.php">Mon profil</a>';
            } else {
                // Afficher le bouton "Connexion" et le lien vers la création de compte
                echo '<a class="Connexion" href="../profil/login.php">Connexion</a>';
                echo '<a class="Connexion" href="../profil/createAccount.php">Créer un compte</a>';
            }
            ?>
        </div>
    </header>
    <h1>Publier une recette</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Nom de la recette :</label>
        <input type="text" name="name" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea><br>

        <label for="image">Image :</label>
        <input type="file" name="image"><br>

        <label for="fornumber">Pour combien de personnes :</label>
        <input type="number" name="fornumber" required><br>

        <label for="time">Temps de préparation :</label>
        <input type="text" name="time" required><br>

        <label for="difficulty">Difficulté :</label>
        <input type="text" name="difficulty" required><br>

        <input type="submit" value="Envoyer à un administrateur">
    </form>
    <footer>
        <div>
            <?php
                
                if (isset($_SESSION['idUser'])) {
                    echo ' <a href="../accueil/home.php?success=1">← Retour</a>';

                } else {
                    echo '<a href="../accueil/home.php?success=0">Connexion</a>';
                }
                ?>
                
            </div>
    </footer>
</body>

</html>
