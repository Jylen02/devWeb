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
    <?php
        $servername = "localhost";
        $username = "projetRecdevweb";
        $password = "projetRecdevweb2023";
        $dbname = "information_utilisateur";

        new mysqli($servername, $username, $password, $dbname);
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }
    ?>
</body>
</html>