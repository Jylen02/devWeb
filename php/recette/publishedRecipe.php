<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include_once("../Head.php");
    include_once("../database.php");
    session_start();
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/imageSetting.css">
    <link rel="stylesheet" type="text/css" href="../../css/publishedRecipe.css">
    <script src="../../js/home.js" type="text/javascript"></script>
    <title>Publier une recette</title>
    <style>
        .center{
            text-align: center;
        }
    </style>
</head>

<body>
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
        <form method="POST" action="insertRecipe.php" enctype="multipart/form-data">
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
        <div class="center">
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