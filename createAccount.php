<!DOCTYPE html>
<html>
<head>
    <title>Cuisine pour les nuls</title>
    <link rel="stylesheet"
    type="text/css"
    href="recette.css">
    <link rel="stylesheet"
    type="text/css"
    href="createAccount.css">
    <script src="createAccount.js" type="text/javascript">
    </script>
</head>
<body>
    <div>
        <a href="home.php" id="retourAcceuil">
        <- Accueil
        </a>
    </div>
    <div id="corps">
        <div id="titre">
            S'incrire
        </div>
        <div>
            <form action="User.php" method="POST">
                <div class="SignUp">
                    <label for="email">
                        E-mail : 
                    </label>
                    </br>
                    <input type="text" id="email" name="email" autofocus="autofocus" required>
                    </br>
                    <label for="username">
                        Identifiant : 
                    </label>
                    </br>
                    <input type="text" id="username" name="username" required>
                    </br>
                    <label for="password">
                        Mot de passe : 
                    </label>
                    </br>
                    <input type="password" id="password" name="password" class=password required>
                    </br>
                    <label for="confirmPassword">
                        Confirmer le mot de passe : 
                    </label>
                    </br>
                    <input type="password" id="confirmPassword" name="confirmPassword" class=password oninput="checkPass()" required>
                    </br>
                    <div id="message"></div>
                    <button type="submit" id="submit" onclick=ajouter_utilisateur()>Continuer</button>
                </div>
            </form>
        </div>
        <div class="SignIn">
            <a href="login.php" id="SignIn">
                Déjà un compte ? Connectez-vous
            </a> 
        </div>
    </div>
</body>
</html>