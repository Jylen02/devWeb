<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once("Head.php");
        if (isset($_GET['success']) && $_GET['success'] == 0) {
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
            }
            echo "<script> alert(\"Erreur lors de la création du compte : $error.\")</script>";
        }
        else if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<script> alert(\"Le mail choisi est déjà utilisé, veuillez en choisir un nouveau.\")</script>";
        }
        else if (isset($_GET['success']) && $_GET['success'] == 2) {
            echo "<script> alert(\"Le nom d'utilisateur choisi est déjà utilisé, veuillez en choisir un nouveau.\")</script>";
        }
    ?>
    <link rel="stylesheet"
    type="text/css"
    href="../css/createAccount.css">
    <script src="../js/createAccount.js" type="text/javascript">
    </script>
    
</head>
<body>
    <div>
        <a href="home.php" id="retourAcceuil">
        ← Accueil
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
                    <input type="password" id="password" name="password" class=password oninput="checkPass()" required>
                    </br>
                    <label for="confirmPassword">
                        Confirmer le mot de passe : 
                    </label>
                    </br>
                    <input type="password" id="confirmPassword" name="confirmPassword" class=password oninput="checkPass()" required>
                    </br>
                    <div id="message"></div>
                    <button type="submit" id="submit" >Continuer</button>
                    
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