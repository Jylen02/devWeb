<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../Head.php"); ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/consulteRecipe.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des recettes à traiter</title>
</head>

<body>
    <?php
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");

    // Récupération des recettes depuis la table "recipeinprocess"
    $sql = "SELECT id, idUser, name FROM recipeinprocess";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $recettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <h1>Liste des recettes</h1>

    <ul>
        <?php foreach ($recettes as $recette) : ?>
            <li>
                <p><?php echo $recette['idUser'] ; ?>
                <a href="consulteAllRecipe.php?id=<?php echo $recette['id']; ?>"><?php echo $recette['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <footer>
    <div class="center">
            <?php
                session_start();
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
