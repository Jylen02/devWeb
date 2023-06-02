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
        $destination = "../../image" . $_FILES['image']['name'];
        move_uploaded_file($image, $destination);
    } else {
        $image = null;
    }

    // Connexion à la base de données et insertion des données dans la table "recipeinprocess"
    $pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    try {
        // Insérer les données de la recette dans la table "recipeinprocess"
        $sql = "INSERT INTO recipeinprocess (idUser, name, description, image, fornumber, time, difficulty) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUser, $name, $description, $image, $fornumber, $time, $difficulty]);

        if ($stmt->rowCount() > 0) {
            // Une nouvelle ligne a été insérée avec succès
            echo "Nouvelle ligne insérée dans la table recipeinprocess.";
        } else {
            // Aucune ligne insérée (erreur ou aucune modification)
            echo "Aucune ligne insérée dans la table recipeinprocess.";
        }
        // Récupérer l'ID de la recette insérée
        $recipeId = $pdo->lastInsertId();

        // Insérer les ingrédients de la recette dans la table "product"
        $ingredients = $_POST['ingredient_name'];
        $quantities = $_POST['ingredient_quantity'];

        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = $ingredients[$i];
            $quantity = $quantities[$i];

            $sql = "INSERT INTO product (recipeId, ingredient, quantity) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$recipeId, $ingredient, $quantity]);
        }

        // Calculer et mettre à jour le prix dans la table "recipeinprocess"
        $sql = "UPDATE recipeinprocess SET price = (
            SELECT SUM(p.price * ri.quantity)
            FROM product ri
            JOIN productlist p ON ri.name = p.name
            WHERE ri.recipeId = ?
        ) WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$recipeId, $recipeId]);

        // Vider la table "product" pour les calculs futurs
        $sql = "TRUNCATE TABLE product";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $pdo->commit();

        // Succès de l'enregistrement
        echo "<script>alert('La publication s'est faite avec succès!');</script>";
        // Redirection vers une page de confirmation ou une autre action souhaitée
        if (isset($_SESSION['idUser'])) {
            echo "<script>window.location.href = '../accueil/home.php?success=1';</script>";
        } else {
            echo "<script>window.location.href = '../accueil/home.php?success=0';</script>";
        }
    } catch (PDOException $e) {
        // Erreur lors de l'enregistrement
        $pdo->rollback();
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

<div class="center">
    <h1>Publier une recette</h1>
</div>

<div class="recette-details">
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
    <div class="center">
    
        <?php
        if (isset($_SESSION['idUser'])) {
            echo '<a href="../accueil/home.php?success=1">← Retour</a>';
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
