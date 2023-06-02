<!DOCTYPE html>
<html lang="fr">  
<head>
    <?php
    include_once("../Head.php");
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/imageSetting.css">
    <link rel="stylesheet" type="text/css" href="../../css/publishedRecipe.css">
    <script src="../../js/home.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une recette</title>
</head>
<body>
    <?php
    include_once("../database.php");
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
        $titre = $_POST['name'];
        $description = $_POST['description'];
        //$prix = $_POST['prix'];
        $personnes = $_POST['personnes'];
        $temps = $_POST['temps'];
        $difficulte = $_POST['difficulte'];

        // Traitement de l'image
        $image = $_FILES['image'];
        $imagePath = uploadImage($image);

        
        // Requête SQL pour insérer la recette dans la table "recipe"
        $requeteInsertion = "INSERT INTO recipe (name, description, image, idUser, fornumber, time, difficulty)
                             VALUES ('$titre', '$description', '$imagePath','".$_SESSION['idUser']."', $personnes, '$temps', '$difficulte')";

        // Exécution de la requête d'insertion
        if (mysqli_query($connexion, $requeteInsertion)) {
            // Rediriger l'utilisateur vers la page d'accueil avec un message de succès
            alert('La recette a été envoyé avec succès');
            //header("Location: home.php?success=1");
            //exit();
        } else {
            echo "Erreur lors de l'insertion de la recette : " . mysqli_error($connexion);
        }

        // Récupérer l'ID de la recette insérée
        $recipeId = $pdo->lastInsertId();

        // Insérer les ingrédients de la recette dans la table "product"
        $ingredients = $_POST['ingredient_name'];
        $quantities = $_POST['ingredient_quantity'];

        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = $ingredients[$i];
            $quantity = $quantities[$i];
            $sqluu = "INSERT INTO product (idRecipe, name, amount) VALUES ($recipeId, $ingredient, $quantity)";
            $resulta_sqluu = mysqli_query($connexion, $sqluu);
        }

        // Calculer et mettre à jour le prix dans la table "recipeinprocess"
        $sql = "UPDATE recipeinprocess SET price = (
            SELECT SUM(p.price * ri.amount)
            FROM product ri
            JOIN productlist p ON ri.name = p.name
            WHERE ri.idRecipe = $recipeId
        ) WHERE id = $recipeId";
        $resulta_sql = mysqli_query($connexion, $sql);
        // Succès de l'enregistrement
        echo "<script>alert('L'envoie s'est faite avec succès!');</script>";
        // Redirection vers une page de confirmation ou une autre action souhaitée
        if (isset($_SESSION['idUser'])) {
            echo "<script>window.location.href = '../accueil/home.php?success=1';</script>";
        } else {
            echo "<script>window.location.href = '../accueil/home.php?success=0';</script>";
        }

        // Fermeture de la connexion à la base de données
        mysqli_close($connexion);
    }
    else{
        echo "<script>alert('Une erreur est survenue lors de l'enregistrement de la publication. Veuillez réessayer.');</script>";

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

    <div class="center">
    <h1>Publier une recette</h1>
</div>

<div class="recette-details" id="content">
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Nom de la recette :</label>
        <input type="text" name="name" required><br>

        <label for="description">Description :</label>
        <textarea name="description" required rows="7" cols="70"></textarea><br>

        <label for="image">Image :</label>
        <input type="file" name="image"><br>

        <label for="fornumber">Pour combien de personnes :</label>
        <input type="number" name="fornumber" required><br>

        <label for="time">Temps de préparation :</label>
        <input type="text" name="time" required required placeholder="en heure"><br>

        <label for="difficulty">Difficulté :</label>
        <select name="difficulty" required placeholder="difficulty">
            <option value='facile'> facile</option>
            <option value='moyen'> moyen</option>
            <option value='difficile'> difficile</option>
        </select>

        <div id="ingredients-container">
            <div class="ingredient-row">
                <select name="ingredient_name[]">
                    <?php
                    // Connexion à la base de données pour récupérer la liste des ingrédients
                    $pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");
                    $sql = "SELECT name FROM productlist";
                    $stmt = $pdo->query($sql);
                    $ingredients = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($ingredients as $ingredient) {
                        echo "<option value='$ingredient'>$ingredient</option>";
                    }
                    ?>
                </select>
                <input type="text" name="ingredient_quantity[]" required placeholder="Quantité*">
                <button type="button" class="remove-ingredient">Supprimer</button>
            </div>
        </div>

        <button type="button" id="add-ingredient">Ajouter un ingrédient</button>
        
        <input type="submit" value="Envoyer à un administrateur"></br>
        <label><small>Quantité : Les quantités sont valorisées sur le prix :
            </br>- Au kilos pour les produits solides
            </br>- Au litre pour les produits liquides
            </br>- Au prix unitaire pour les produits élémentaires
                </small> </label></br>
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
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        const addIngredientBtn = document.getElementById('add-ingredient');
        const ingredientsContainer = document.getElementById('ingredients-container');

        addIngredientBtn.addEventListener('click', () => {
            const ingredientRow = document.createElement('div');
            ingredientRow.className = 'ingredient-row';

            const select = document.createElement('select');
            select.name = 'ingredient_name[]';
            <?php
                foreach ($ingredients as $ingredient) {
                    echo "select.innerHTML += '<option value=\"$ingredient\">$ingredient</option>';\n";
                }
            ?>

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'ingredient_quantity[]';
            input.required = true;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-ingredient';
            removeBtn.textContent = 'Supprimer';
            removeBtn.addEventListener('click', () => {
                ingredientRow.remove();
            });

            ingredientRow.appendChild(select);
            ingredientRow.appendChild(input);
            ingredientRow.appendChild(removeBtn);

            ingredientsContainer.appendChild(ingredientRow);
        });
    });
</script>
</body>
</html>