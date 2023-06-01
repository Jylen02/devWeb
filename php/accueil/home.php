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
            Recettes recommandés :
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