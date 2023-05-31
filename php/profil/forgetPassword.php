<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once("../Head.php");
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<script> alert(\"Veuillez entrer votre nouveau mot de passe.\")</script>";
        }
        else if (isset($_GET['success']) && $_GET['success'] == 2) {
            echo "<script> alert(\"Le mail n'existe pas, veuillez en créer un.\")</script>";
        }
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/forgetPassword.css">
</head>
<body>
    <div>
        <a href="login.php" id="retourLogin">
        ← Retour
        </a>
    </div>
    <div id="corps">
        <div id="titre">
            Mot de passe oublié
        </div>
        <div>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
                <form action="resetPassword.php" method="POST">
                    <div class="Password">
                    <label for="password">
                        Mot de passe : 
                    </label>
                    </br>
                    <input type="password" id="password" name="password" class=password oninput="checkPass()" required>
                    </br>
                    <label for="confirmPassword">
                        Confirmer le mot de passe : 
                    </label>
                    </br>
                    <input type="password" id="confirmPassword" name="confirmPassword" class=password oninput="checkPass()" required>
                    </br>
                    <div id="message"></div>
                    <button type="submit" id="submit" >Envoyer</button>
                    </div>
                </form>
            <?php } else { ?>
                <form action="resetPassword.php" method="POST">
                    <div class="Email">
                        <label for="email">
                            E-mail :
                        </label>
                        </br>
                        <input type="text" id="email" name="email" autofocus="autofocus" required>
                        </br>
                        <button type="submit">Envoyer</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
