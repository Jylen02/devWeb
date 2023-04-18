<!DOCTYPE html>
<html>   
<head>
    <title>Cuisine pour les nuls</title>
    <link rel="stylesheet"
    type="text/css"
    href="recette.css">
    <link rel="stylesheet"
    type="text/css"
    href="home.css">
</head>
<body>
    <div id="top">
        <div>
            <form id="formRecherche">
                <input type="text" placeholder="Rechercher une recette" id="barreRecherche">
            </form>
        </div>
        <div>
            <a href="login.php" id="login" class="Connexion">
                Connexion
            </a>
            <a href="createAccount.php" id="createAccount" class="Connexion">
                Cr&eacute;er un compte
            </a>
        </div>
    </div>
<script>
    document.getElementById("barreRecherche").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        // Récupérer la valeur de l'input
        var recherche = document.getElementById("barreRecherche").value;
        alert(recherche);
        // Récuperer depuis la BDD les tags et afficher un format img / titre / description
        $db = 'projet';
        $connexion = mysqli_connect('localhost','root');
    }
});
</script>
</body>
</html>