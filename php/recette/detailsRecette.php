<!DOCTYPE html>
<html lang="fr">

<head>
    <?php 
    session_start();
    include_once("../Head.php");
    include_once("../database.php"); ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/detailsRecette.css">
    <script src="../../js/home.js" type="text/javascript">
    </script>


</head>

<body>
    <header>
        <div class="recette-details">
            <?php
            // Vérification si l'ID de la recette est passé en paramètre dans l'URL
            if (isset($_GET['id'])) {
                $idRecette = $_GET['id'];
                if (isset($_GET['enableComment'])){
                    $enableComment = $_GET['enableComment'];
                    $updateRecette = "UPDATE recipe SET enableComment = '$enableComment' WHERE id = '$idRecette'";
                    $resultatUpdate = mysqli_query($connexion, $updateRecette);
                    if ($resultatUpdate) {
                        if ($enableComment==1){
                            echo "<script>alert('Les commentaires sont désormais activé !');</script>";
                        } else {
                            echo "<script>alert('Les commentaires sont désormais désactivés !');</script>";
                        }
                    } else {
                        echo "<script>alert('Erreur lors de la modification d'autorisation des commentaires.');</script>";
                    }
                }

                // Requête SQL pour récupérer tous les attributs de la recette
                $requeteRecette = "SELECT name, description, image, score, time, enableComment, fornumber, difficulty, price FROM recipe WHERE id = $idRecette";
                $resultatRecette = mysqli_query($connexion, $requeteRecette);

                if (mysqli_num_rows($resultatRecette) > 0) {
                    $rowRecette = mysqli_fetch_assoc($resultatRecette);
                    $titre = $rowRecette['name'];
                    $description = $rowRecette['description'];
                    $image = $rowRecette['image'];
                    $moyenneScore = $rowRecette['score'];
                    $time = $rowRecette['time'];
                    $enableComment = $rowRecette['enableComment'];
                    $fornumber = $rowRecette['fornumber'];
                    $difficulty = $rowRecette['difficulty'];
                    $price = $rowRecette['price'];
                    $_SESSION['enableComment'] = $enableComment;
                } else {
                    echo "Aucune recette trouvée.";
                }
                // Libération des résultats de la requête de la recette
                mysqli_free_result($resultatRecette);
            }

            echo "<h1>$titre</h1>
                <header><img src='affichageImage.php?id=$idRecette' alt='$titre' width='200'></header>";
            echo "<div class='align'>";
            echo "<div class='recette-details-item'><span>Pour :</span> <span>$fornumber</span></div>";
            echo "<div class='recette-details-item'><span>coût estimé :</span> <span>$price euros</span></div>";
            echo "<div class='recette-details-item'><span>Durée :</span> <span>$time heure</span></div>";
            echo "<div class='recette-details-item'><span>Difficulté :</span> <span>$difficulty</span></div>";
            echo "</div>";

            ?>
        </div>

    </header>

    <aside>
        <?php
        echo "<aside> Description de la recette :
                <p>$description</p></aside>";
        ?>
    </aside>
    <footer>
        <div>
            <?php
            $enableComment = $_SESSION['enableComment'];
            echo "<h3 style='color: red;'>Note : $moyenneScore/5 ";

            if ($enableComment == 1) {
                echo "(<a href='scoreRecette.php?id=$idRecette'> voir les commentaires</a> /
          <a href='evaluation.php?id=$idRecette' class='evaluer-button'>évaluer</a> la recette - $titre -)";
            } else {
                echo "(<a href='scoreRecette.php?id=$idRecette'> voir les commentaires</a> - $titre -)";
            }
            echo "</h3><br>";
            
            // Fermeture de la connexion à la base de données
            mysqli_close($connexion);
            ?>
        </div>

        <div>
            <?php
            if (isset($_SESSION['idUser'])) {
                echo ' <a href="../accueil/home.php?success=1">← Retour</a><br>';
                if ($_SESSION['idUser'] == "admin") {
                    $id = $_GET['id'];
                    $enableComment = $_SESSION['enableComment'];
                    if ($enableComment == 1) {
                        echo '<a href="detailsRecette.php?id=' . $id . '&enableComment=0">Desactiver commentaire</a><br>';
                    } else {
                        echo '<a href="detailsRecette.php?id=' . $id . '&enableComment=1">Activer commentaire</a><br>';
                    }
                }
            } else {
                echo '<a href="../accueil/home.php?success=0">Connexion</a><br>';
            }
            ?>

        </div>
    </footer>
</body>

</html>