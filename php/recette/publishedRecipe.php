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

    // Vérification si l'utilisateur est connecté
    if (!isset($_SESSION['idUser'])) {
        // Rediriger l'utilisateur vers la page de connexion
        header("Location: ../profil/login.php");
        exit();
    }

    // Vérification si l'utilisateur est l'administrateur
    if ($_SESSION['idUser'] === 'admin') {
        // Rediriger l'administrateur vers la page de consultation des recettes
        header("Location: consulteRecipe.php");
        exit();
    }

    // Traitement du formulaire de création de recette
    if (isset($_POST['submit'])) {
        // Récupération des données du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $personnes = $_POST['personnes'];
        $temps = $_POST['temps'];
        $difficulte = $_POST['difficulte'];

        // Traitement de l'image
        $image = $_FILES['image'];
        $imagePath = uploadImage($image);

        // Connexion à la base de données
        $serveur = "localhost";
        $utilisateur = "projetRecdevweb";
        $motDePasse = "projetRecdevweb2023";
        $baseDeDonnees = "website_database";

        $connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

        // Vérification de la connexion à la base de données
        if (!$connexion) {
            die("Connexion à la base de données échouée : " . mysqli_connect_error());
        }

        // Requête SQL pour insérer la recette dans la table "recipe"
        $requeteInsertion = "INSERT INTO recipe (title, description, image, price, servings, time, difficulty, idUser, status)
                             VALUES ('$titre', '$description', '$imagePath', $prix, $personnes, '$temps', '$difficulte', '".$_SESSION['idUser']."', 'pending')";

        // Exécution de la requête d'insertion
        if (mysqli_query($connexion, $requeteInsertion)) {
            // Rediriger l'utilisateur vers la page d'accueil avec un message de succès
            header("Location: home.php?success=1");
            exit();
        } else {
            echo "Erreur lors de l'insertion de la recette : " . mysqli_error($connexion);
        }

        // Fermeture de la connexion à la base de données
        mysqli_close($connexion);
    }

    // Fonction pour gérer le téléchargement et l'enregistrement de l'image
    function uploadImage($image) {
        // Vérifier si le téléchargement de l'image a réussi
        if ($image['error'] === 0) {
            // Chemin de destination de l'image (dossier "uploads" avec un nom de fichier unique)
            $destination = "../../uploads/" . uniqid() . "_" . $image['name'];

            // Déplacer l'image téléchargée vers le dossier de destination
            move_uploaded_file($image['tmp_name'], $destination);

            // Retourner le chemin de l'image
            return $destination;
        } else {
            echo "Erreur lors du téléchargement de l'image.";
            return "";
        }
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

    <div id="content">
        <h1>Publier une recette</h1>
        <form action="publishedRecipe.php" method="POST" enctype="multipart/form-data">
            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required><br>

            <label for="description">Description :</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="image">Image :</label>
            <input type="file" id="image" name="image" required><br>

            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" required><br>

            <label for="personnes">Nombre de personnes :</label>
            <input type="number" id="personnes" name="personnes" required><br>

            <label for="temps">Temps :</label>
            <input type="text" id="temps" name="temps" required><br>

            <label for="difficulte">Difficulté :</label>
            <select id="difficulte" name="difficulte" required>
                <option value="Facile">Facile</option>
                <option value="Moyenne">Moyenne</option>
                <option value="Difficile">Difficile</option>
            </select><br>

            <input type="submit" name="submit" value="Envoyer à un administrateur">
        </form>
    </div>
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
