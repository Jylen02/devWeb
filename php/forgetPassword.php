<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once("Head.php");
    ?>
    <link rel="stylesheet"
    type="text/css"
    href="../css/forgetPassword.css">
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
            <form action="UserCreate.php" method="POST">
                <div class="Email">
                    <label for="email">
                        E-mail : 
                    </label>
                    </br>
                    <input type="text" id="email" name="email" autofocus="autofocus" required>
                    </br>
                    <button type="submit" onclick="verifier_utilisateur()">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>