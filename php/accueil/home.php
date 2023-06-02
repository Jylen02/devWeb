<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include_once("../Head.php");
    include_once("../database.php");
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <script> var username = "<?php echo isset($_SESSION['idUser']) ? $_SESSION['idUser'] : ''; ?>"; </script>
    <script src="../../js/home.js" type="text/javascript"> </script>

</head>

<body
    onload="load(<?php session_start();
    echo isset($_SESSION['idUser']) ? 'true' : 'false'; ?>, '<?php echo isset($_SESSION['idUser']) ? $_SESSION['idUser'] : ''; ?>')">
    <header>
        <div id="top">
            <div id="barre">
                <form id="formRecherche">
                    <input type="text" placeholder="Rechercher une recette" id="barreRecherche">
                </form>
            </div>
        </div>
        <div id="top2">
        </div>
    </header>

    <div id="container">
        <div id="resultats">
            <?php
            if (isset($_SESSION['idUser'])) {
                echo "Recettes favories : ";
                $idUser = $_SESSION['idUser'];
                // Requête SQL pour récupérer le titre, la description et l'image de la recette correspondante dans la table "recipe"
                $recetteFavori = "SELECT recipe.name, recipe.id, recipe.description, recipe.image, recipe.score FROM recipe 
                        JOIN evaluation ON evaluation.idRecipe = recipe.id
                        JOIN user ON user.username = evaluation.idUser
                        WHERE evaluation.score >= 3 AND user.username = ?";
                //$queryRecipe = "SELECT name, id, description, image, score FROM recipe WHERE idUser = ?";
                $stmt = $connexion->prepare($recetteFavori);
                $stmt->bind_param("s", $idUser);
                $stmt->execute();
                $resultRecipe = $stmt->get_result();

                if ($resultRecipe && $resultRecipe->num_rows > 0) {
                    while ($rowRecette = mysqli_fetch_assoc($resultRecipe)) {
                        // Affichage des résultats de la recette
                        $title = $rowRecette['name'];
                        $description = $rowRecette['description'];
                        $image = $rowRecette['image'];
                        $id = $rowRecette['id'];
                        $averageScore = round($rowRecette['score']);
                        $stars = str_repeat("*", $averageScore);

                        // Affichage des résultats avec l'image
                        echo "<br>";
                        echo "<section class='info'>";
                            //Affiche l'image de la recette
                            echo "<section class='image'>";
                                echo "<img src='../recette/affichageImage.php?id=$id' width='100'>";
                            echo "</section>";
                            echo "<section class='recette'>";
                                echo "<h2><a href='../recette/detailsRecette.php?id=$id'>$title</a>
                                        <a href='../recette/scoreRecette.php?id=$id' style='color: red;'>$stars</a></h2><br> ";
                            echo "</section>";
                        echo "</section>";
                        echo "<hr>";
                    }
                } else {
                    echo "Aucune recette favorie.";
                    echo "<hr>";
                }
            }
            echo "Recettes recommandées : ";
            $recetteRecommande = "SELECT DISTINCT name, id, description, image, score FROM recipe 
                        WHERE recipe.score >= 3.5 AND id NOT IN (SELECT recipe.id FROM recipe 
                        JOIN evaluation ON evaluation.idRecipe = recipe.id
                        JOIN user ON user.username = evaluation.idUser
                        WHERE evaluation.score > 3 AND user.username = ?)";
            $stmt1 = $connexion->prepare($recetteRecommande);
            $stmt1->bind_param("s", $idUser);
            $stmt1->execute();
            $resultRecommande = $stmt1->get_result();
            if ($resultRecommande && $resultRecommande->num_rows > 0) {
                while ($rowRecette = mysqli_fetch_assoc($resultRecommande)) {
                    // Affichage des résultats de la recette
                    $title = $rowRecette['name'];
                    $description = $rowRecette['description'];
                    $image = $rowRecette['image'];
                    $id = $rowRecette['id'];
                    $averageScore = round($rowRecette['score']);
                    $stars = str_repeat("*", $averageScore);

                    // Affichage des résultats avec l'image
                    // Affichage des résultats avec l'image
                    echo "<br>";
                    echo "<section class='info'>";
                        //Affiche l'image de la recette
                        echo "<section class='image'>";
                            echo "<img src='../recette/affichageImage.php?id=$id' width='100'>";
                        echo "</section>";
                        echo "<section class='recette'>";
                            echo "<h2><a href='../recette/detailsRecette.php?id=$id'>$title</a>
                                    <a href='../recette/scoreRecette.php?id=$id' style='color: red;'>$stars</a></h2><br> ";
                        echo "</section>";
                    echo "</section>";
                    echo "<hr>";
                }
            } else {
                echo "Aucune recette recommandée.";
                echo "<hr>";
            }
            ?>
        </div>
        <div id="bestUser">
            Utilisateur le mieux noté de la semaine :
            <?php
            $command = "SELECT username FROM user ORDER BY score DESC LIMIT 1";

            // Exécuter la requête SQL
            $resultat = mysqli_query($connexion, $command);

            if (mysqli_num_rows($resultat) > 0) {
                while ($rowCommentaire = mysqli_fetch_assoc($resultat)) {
                    $username = $rowCommentaire['username'];
                    echo "$username";
                    echo "<img src='../recette/affichageAvatar.php?id=$username' width='200'>";
                }
            }

            // Fermeture de la connexion à la base de données
            mysqli_close($connexion);
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#formRecherche').submit(function (e) {
                e.preventDefault(); // Empêche la soumission du formulaire

                var recherche = $('#barreRecherche').val(); // Récupère le texte de la barre de recherche

                $.ajax({
                    url: 'recherche.php',
                    type: 'POST',
                    data: { recherche: recherche },
                    success: function (response) {
                        $('#resultats').html(response); // Affiche les résultats dans la div avec l'ID "resultats"
                    }
                });
            });
        });
    </script>
</body>

</html>