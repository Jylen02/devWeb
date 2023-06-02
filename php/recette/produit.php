<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include_once("../Head.php");
    include_once("../database.php");
    session_start();
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/produit.css">
    <script> var username = "<?php echo isset($_SESSION['idUser']) ? $_SESSION['idUser'] : ''; ?>"; </script>
    <script src="../../js/product.js" type="text/javascript"> </script>
</head>

<body>
    <h1 class="center">Liste des produits</h1>

    <?php
    // Récupérer les données de la table productList
    $queryProduct = "SELECT name, price FROM productList";
    $resultProduct = $connexion->query($queryProduct);

    if ($resultProduct->num_rows > 0) {
        // Afficher le tableau si des données sont disponibles
        echo "<table><tbody>";
        echo "<tr><th>Ingrédient</th><th>Prix</th></tr>";
        while ($row = $resultProduct->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["price"] . "</td>";
            echo "<td><button onclick='changePrice(" . $row["price"] . ", \"" . $row["name"] . "\")'>Modifier prix</button></td>";
            echo "<td><button onclick='deleteIngredient(\"" . $row["name"] . "\")'>Supprimer</button></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "<div class='center'>";
        echo "<button  onclick='addIngredient()' >Ajouter ingrédient</button>";
        echo "</div>";
    } else {
        echo "Aucun produit trouvé dans la base de données.";
    }

    // Fermer la connexion à la base de données
    $connexion->close();
    ?>
    <div class="center">
        <a href="../accueil/home.php" id="retourAccueil">
            ← Accueil
        </a>
    </div>
</body>

</html>