<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once("Head.php");
    ?>
    <link rel="stylesheet"
    type="text/css"
    href="../css/login.css">
</head>
<body>
    <div>
        <a href="home.php" id="retourAcceuil">
        ← Accueil
        </a>
    </div>
    <div id="corps">
        <div id="titre">
            Se connecter
        </div>
        <div>
            <form action="UserLogin.php" method="POST">
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
                    <button type="submit">Continuer</button>
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