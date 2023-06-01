<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la recette</title>
</head>

<body>
    <?php
    // Vérification si l'ID de la recette a été fourni dans l'URL
    if (isset($_GET['id'])) {
        // Récupération de l'ID de la recette
        $idRecette = $_GET['id'];

        // Connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");

        // Récupération des détails de la recette depuis la table recipeinprocess
        $sql = "SELECT idUser, name, description, image, fornumber, time, difficulty FROM recipeinprocess WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idRecette]);
        $recette = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification si la recette existe
        if ($recette) {
            // Affichage des détails de la recette
            echo "<h1>{$recette['name']}</h1>";
            echo "<p><strong>Utilisateur :</strong> {$recette['idUser']}</p>";
            echo "<p><strong>Description :</strong> {$recette['description']}</p>";
            echo "<p><strong>Pour combien de personnes :</strong> {$recette['fornumber']}</p>";
            echo "<p><strong>Temps de préparation :</strong> {$recette['time']}</p>";
            echo "<p><strong>Difficulté :</strong> {$recette['difficulty']}</p>";
            if ($recette['image']) {
                echo "<img src='{$recette['image']}' alt='Image de la recette'>";
            } else {
                echo "<p>Aucune image disponible</p>";
            }
        } else {
            echo "<p>La recette demandée n'existe pas.</p>";
        }
    } else {
        echo "<p>Erreur : Aucun ID de recette spécifié.</p>";
    }
    ?>

    <footer>
        <a href="consulteRecipe.php">Retour</a>
    </footer>
</body>

</html>
