<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include_once("../Head.php");
    include_once("../database.php");
    session_start();
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/consulteRecipe.css">
</head>

<body>
    <?php
    // Récupération des recettes depuis la table "recipe"
    $sql = "SELECT id, idUser, name FROM recipe WHERE valid = 0";
    $result = $connexion->query($sql);

    // Vérification si des recettes ont été trouvées
    if ($result && $result->num_rows > 0) {
        $recettes = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $recettes = array();
    }
    ?>

    <h1 class="center">Liste des recettes <span class="rouge">en cours de validation</span></h1>

    <table cellspacing=10 cellpadding=10 >
        <tr>
            <th>Nom de l'utilisateur</th>
            <th>Nom de la recette</th>
        </tr>
        <?php foreach ($recettes as $recette): ?>
            <tr>
                <td>
                    <?php echo $recette['idUser']; ?>
                </td>
                <td><a href="consulteRecipe.php?id=<?php echo $recette['id']; ?>"><?php echo $recette['name']; ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>




    <?php
    // Récupération des recettes depuis la table "recipe"
    $sql = "SELECT id, idUser, name FROM recipe WHERE valid = 1";
    $result = $connexion->query($sql);

    // Vérification si des recettes ont été trouvées
    if ($result && $result->num_rows > 0) {
        $recettes = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $recettes = array();
    }
    ?>

    <h1 class="center">Liste des recettes <span class="vert">en lignes</span></h1>

    <table cellspacing=10 cellpadding=10 >
        <tr>
            <th>Nom de l'utilisateur</th>
            <th>Nom de la recette</th>
        </tr>
        <?php foreach ($recettes as $recette): ?>
            <tr>
                <td>
                    <?php echo $recette['idUser']; ?>
                </td>
                <td><a href="consulteRecipe.php?id=<?php echo $recette['id']; ?>"><?php echo $recette['name']; ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    

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
</body>

</html>