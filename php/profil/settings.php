<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once("../Head.php");
        session_start();
        $idUser = $_SESSION('idUser');
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/settings.css">
    <script type="text/javascript" src="../../js/settings.js"> </script>
</head>
<body class=" bgcolorWhite" onload="click1(['lucas','Guillot','test1','e-mail','test1.com'])">

    <div class="bar" id="main">
        
        <div role="tablist" class="leftBar" align="right">
            <div tabindex="-2" class="retourAccueil">
                <a href="../accueil/home.php" id="retourAccueil">
                ← Accueil
                </a>
            </div>
            <div tabindex="-1" role="button">Paramètres utilisateur</div>
            <div>
                <input tabindex="0"  type="button" name="button_settings" value="profil"        class="input" 
                onclick="click1(['lucas','guillot','test1','e-mail','test1.com'])"  onmouseover="mouseOver(1)" onmouseout="mouseOut(1)">
            </div>
            <div>
                <input tabindex="-1" type="button" name="button_settings" value="accessibilité" class="input" 
                onclick="click2()"  onmouseover="mouseOver(2)" onmouseout="mouseOut(2)">
            </div>
            <div>
                <input tabindex="-1" type="button" name="button_settings" value="commentaires"  class="input" 
                onclick="click3()" onmouseover="mouseOver(3)" onmouseout="mouseOut(3)">
            </div>
            <div>
                <input tabindex="-1" type="button" name="button_settings" value="notifications" class="input" 
                onclick="click4()" onmouseover="mouseOver(4)" onmouseout="mouseOut(4)">
            </div>
        </div>
        <div>
            
        </div>
    </div>
</body>
</html>
<?php
    // $hash = password_hash("rasmuslerdorf", PASSWORD_DEFAULT); pour les mot de passe

    $db = 'projet';
    $connexion = mysqli_connect('localhost','root');
    
    function create($db,$connexion) {
        $command='CREATE DATABASE '.$db;
        mysqli_select_db($connexion,$db);
    
        $resultat = mysqli_query($connexion,$command);
    
        $command = "CREATE TABLE IF NOT EXISTS utilisateur (identifiant INTEGER(16), prenom CHAR(30), nom CHAR(30), 
        pseudonyme CHAR(20), email CHAR(50), motDePasse CHAR(60), PRIMARY KEY(identifiant)) DEFAULT CHARSET=utf8";
        $resultat = mysqli_query($connexion,$command);
        $command = "INSERT INTO utilisateur (identifiant, prenom, nom, pseudonyme, email, motDePasse) VALUES (0,'lucas','guillot','test1','lucas.guillot@gmail.com','test1.com')";
        $resultat = mysqli_query($connexion,$command);
    }
    
    create($db,$connexion);

    function recupProfil($userName,$password,$connexion) {
        $command="SELECT * FROM utilisateur WHERE $userName=pseudonyme AND $password=motDePasse";
        $resultat=mysqli_query($connexion,$command);
        $res=mysqli_fetch_row($resultat);
        return $res;
    }
    function listerElem($str,$connexion) {
        $command="SELECT * FROM $str";
        $resultat=mysqli_query($connexion,$command);
        $res=[mysqli_fetch_row($resultat)];
        $i=0;
        while ($res[$i]!=null) {
            $i++;
            array_push($res,mysqli_fetch_row($resultat));
        }
        print_r($res);
    }
?>
<?php //echo json_encode(recupProfil('test1','test1.com','projet')) ?>