<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="settings.css">
    <script type="text/javascript" src="settings.js"> </script>
</head>
<body class=" bgcolorWhite" onload="click1(['lucas','Guillot','test1','e-mail','test1.com'])">
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
<script>
    function modify(i) {  
        var profil=['prénom','nom','pseudonyme','adresse e-mail','mot de passe'];
        document.body.setAttribute("class",'modify');
        var newDiv = document.createElement('div');
        newDiv.style.opacity=1;
        var divTitle = document.createElement('div');

        var divTitleMain = document.createElement('div');
        divTitleMain.innerHTML="Changer votre "+profil[i];
        divTitle.appendChild(divTitleMain);
    
        var divTitleSecondary = document.createElement('div');
        divTitleSecondary.innerHTML="Veuillez saisir votre nouveau "+profil[i]+" et votre mot de passe actuel."
        divTitle.appendChild(divTitleSecondary);
    
        var button = document.createElement('button');
        var div = document.createElement('div');
        var svg = document.createElement('svg'); //TODO
        div.appendChild(svg);
        button.appendChild(div);

        var form = document.createElement('form');
        var divForm = document.createElement('div');
    
        var div = document.createElement('div');
        var h2 = document.createElement('h2');
        h2.innerText=profil[i];
        var divBis = document.createElement('div');
        var input = document.createElement('input');
        input.maxLength=100;
        input.type='text';
        divBis.appendChild(input);
        div.appendChild(h2);
        div.appendChild(divBis);
        divForm.appendChild(div);

        var div = document.createElement('div');
        var h2 = document.createElement('h2');
        h2.innerText=profil[4]+" actuel";
        var divBis = document.createElement('div');
        var input = document.createElement('input');
        input.maxLength=100;
        input.type='password';
        divBis.appendChild(input);
        div.appendChild(h2);
        div.appendChild(divBis);
        divForm.appendChild(div);

        var divExit = document.createElement('div');
        var buttonTerminer = document.createElement('button');
        var div = document.createElement('div');
        div.innerHTML='Terminer';
        buttonTerminer.appendChild(div);

        var buttonAnnuler = document.createElement('button');
        var div = document.createElement('div');
        div.innerHTML='Annuler';
        buttonAnnuler.appendChild(div);

        divExit.appendChild(buttonTerminer);
        divExit.appendChild(buttonAnnuler);

        form.appendChild(divForm);
        form.appendChild(divExit);

        newDiv.appendChild(divTitle);
        newDiv.appendChild(form);
        /*newDiv.appendChild(document.createTextNode(
            <?php // $db='projet'; echo json_encode($db); ?>));*/
        document.getElementsByTagName('body')[0].appendChild(newDiv);

        document.body.classList.remove('modify');
    }
    
</script>
    
    <div class="bar" id="main">
        <div role="tablist" class="leftBar" align="right">
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

<?php //echo json_encode(recupProfil('test1','test1.com','projet')) ?>