<!DOCTYPE html>
<html lang="fr">   
<head>
    <?php
        include_once("Head.php");
    ?>
    <link rel="stylesheet"
    type="text/css"
    href="../css/home.css">
    <script src="../js/home.js" type="text/javascript">
    </script>
</head>
<body onload=load(<?php echo (isset($_GET['success']) && $_GET['success'] == 1) ?>)>
<header>
    <div id="top">
        <div id="barre">
            <form id="formRecherche">
                <input type="text" placeholder="Rechercher une recette" id="barreRecherche">
            </form>
        </div>
    </div>
</header>
<div id="resultats"></div>
    <?php
        //Connexion à la BDD
        $servername = "localhost";
        $username = "projetRecdevweb";
        $password = "projetRecdevweb2023";
        $dbname = "website_database";

        new mysqli($servername, $username, $password, $dbname);
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }
    ?>
    
    <!--<script>
        document.getElementById("barreRecherche").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
        // Récupérer la valeur de l'input
        var recherche = document.getElementById("barreRecherche").value;
        alert(recherche);        

        // Récuperer depuis la BDD les tags et afficher un format titre + note
        

        // Afficher la recette selectionnée


        // Poster un commentaire
    }
});
    </script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#formRecherche').submit(function(e) {
                e.preventDefault(); // Empêche la soumission du formulaire

                var recherche = $('#barreRecherche').val(); // Récupère le texte de la barre de recherche

                $.ajax({
                    url: 'recherche.php',
                    type: 'POST',
                    data: { recherche: recherche },
                    success: function(response) {
                        $('#resultats').html(response); // Affiche les résultats dans la div avec l'ID "resultats"
                    }
                });
            });
        });
    </script>

    <?php
    
    ?>

</body>
</html>