<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once("../Head.php");
        session_start();
        $idUser = $_SESSION['idUser'];
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/settings.css">
    <script type="text/javascript" src="../../js/settings.js"> </script>
</head>
<body class="bgcolorWhite">
    <?php

        // Connexion à la base de données
        $servername = "localhost";
        $username1 = "projetRecdevweb";
        $password1 = "projetRecdevweb2023";
        $dbname = "website_database";

        // Création de la connexion
        $connexion = new mysqli($servername, $username1, $password1, $dbname);

        // Vérification de la connexion
        if ($connexion->connect_error) {
            die("Connection failed: " . $connexion->connect_error);
        }

        // Préparation de la requête avec un paramètre lié
        $requeteUser = "SELECT * FROM user WHERE username = ?";
        $stmt = $connexion->prepare($requeteUser);

        // Vérification de la préparation de la requête
        if ($stmt === false) {
            die("Error in prepared statement: " . $connexion->error);
        }

        // Liaison du paramètre et exécution de la requête
        $stmt->bind_param("s", $idUser);
        $stmt->execute();

        // Récupération des résultats
        $resultat = $stmt->get_result();

        // Vérification des résultats
        if ($resultat === false) {
            die("Error in getting result: " . $connexion->error);
        }

        // Récupération de la première ligne de résultats
        $resUser = $resultat->fetch_assoc();

        // Préparation de la requête pour récupérer les commentaires de l'utilisateur
        $requeteCommentaires = "SELECT * FROM evaluation WHERE idUser = ?";
        $stmtCommentaires = $connexion->prepare($requeteCommentaires);

        // Vérification de la préparation de la requête
        if ($stmtCommentaires === false) {
            die("Error in prepared statement: " . $connexion->error);
        }

        // Liaison du paramètre et exécution de la requête
        $stmtCommentaires->bind_param("s", $idUser);
        $stmtCommentaires->execute();

        // Récupération des résultats des commentaires
        $resCommentaires = $stmtCommentaires->get_result();

        // Vérification des résultats
        if ($resCommentaires === false) {
            die("Error in getting result: " . $connexion->error);
        }

        // Récupération de tous les commentaires dans un tableau
        $commentaires = array();
        while ($rowCommentaire = $resCommentaires->fetch_assoc()) {
            $commentaires[] = $rowCommentaire;
        }

        // Fermeture de la requête (le résultat sera utilisé plus tard)
        $stmtCommentaires->close();

        // Fermeture de la requête et de la connexion
        $stmt->close();
        $connexion->close();

    ?>
    <div class="bar" id="main">
    <div role="tablist" class="leftBar" align="right">
        <div tabindex="-2" class="retourAccueil">
            <a href="../accueil/home.php" id="retourAccueil">
            ← Accueil
            </a>
        </div>
        <div tabindex="-1" role="button">Paramètres utilisateur</div>
        <div>
            <script>  var resUser = <?php echo json_encode($resUser); 
            $resUser['profilePictures'] = base64_encode($resUser['profilePictures']);?>; </script>
            <input tabindex="0" type="button" name="button_settings" value="profil" class="input" 
            onclick="click1(resUser)" onmouseover="mouseOver(1)" onmouseout="mouseOut(1)">
        </div>
        <div>
            <input tabindex="-1" type="button" name="button_settings" value="accessibilité" class="input" 
            onclick="click2()" onmouseover="mouseOver(2)" onmouseout="mouseOut(2)">
        </div>
        <div>
            <script> var resComment = <?php echo json_encode($commentaires); ?>; </script>
            <input tabindex="-1" type="button" name="button_settings" value="commentaires" class="input" 
            onclick="click3(resComment)" onmouseover="mouseOver(3)" onmouseout="mouseOut(3)">
        </div>
        <div>
            <input tabindex="-1" type="button" name="button_settings" value="notifications" class="input" 
            onclick="click4()" onmouseover="mouseOver(4)" onmouseout="mouseOut(4)">
        </div>
    </div>

    <script>
        var resUser = <?php echo json_encode($resUser); 
        $resUser['profilePictures'] = base64_encode($resUser['profilePictures']);?>;
        click1(resUser);
    </script>
</body>
</html>
