<!DOCTYPE html>
<html lang="fr">   
<head>
    <?php
        include_once("Head.php");
    ?>
    <link rel="stylesheet"
    type="text/css"
    href="../css/home.css">
</head>
<body>
<header>
    <div id="top">
        <div id="barre">
            <form id="formRecherche">
                <input type="text" placeholder="Rechercher une recette" id="barreRecherche">
            </form>
        </div>
        <div id="divlogin">
            <a href="login.php" id="login" class="Connexion" justify-content="right">
                Connexion
            </a>
            <a href="createAccount.php" id="createAccount" class="Connexion" text-align="right">
                Créer un compte
            </a>
        </div>
    </div>
</header>

    <script>
        document.getElementById("barreRecherche").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            // Récupérer la valeur de l'input
            var recherche = document.getElementById("barreRecherche").value;
            alert(recherche);
            // Récuperer depuis la BDD les tags et afficher un format img / titre / description
            $db = 'projet';
            $connexion = mysqli_connect('localhost','root');
        }
    });
    </script>
</body>
</html>