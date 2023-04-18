<!DOCTYPE html>
<html>
<head>
    <title>Cuisine pour les nuls</title>
    <link rel="stylesheet"
    type="text/css"
    href="recette.css">
    <link rel="stylesheet"
    type="text/css"
    href="forgetPassword.css">
</head>
<body>
    <div>
        <a href="login.php" id="retourLogin">
        <- Retour
        </a>
    </div>
    <div id="corps">
        <div id="titre">
            Mot de passe oublié
        </div>
        <div>
            <form action="User.php" method="POST">
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