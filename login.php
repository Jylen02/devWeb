<!DOCTYPE html>
<html>
<head>
    <title>Cuisine pour les nuls</title>
    <link rel="stylesheet"
    type="text/css"
    href="recette.css">
    <link rel="stylesheet"
    type="text/css"
    href="login.css">
</head>
<body>
    <div>
        <a href="home.php" id="retourAcceuil">
        <- Accueil
        </a>
    </div>
    <div id="corps">
        <div id="titre">
            Se connecter
        </div>
        <div>
            <form action="User.php" method="POST">
                <div class="SignIn">
                    <label for="username">
                        Identifiant : 
                    </label>
                    </br>
                    <input type="text" id="username" name="username" autofocus="autofocus" required>
                    </br>
                    <label for="password">
                        Mot de passe : 
                    </label>
                    </br>
                    <input type="password" id="password" name="password" required>
                    </br>
                    <div class="ForgetPassword">
                        <a href="forgetPassword.php" id="forgetPassword">
                            Mot de passe oublié ?
                        </a> 
                    </div>
                    <button type="submit" onclick="verifier_utilisateur()">Continuer</button>
                </div>
            </form>
        </div>
        <div class="SignUp">
            <a href="createAccount.php" id="signUp">
                Pas de compte ? Inscrivez-vous
            </a> 
        </div>
    </div>
</body>
</html>