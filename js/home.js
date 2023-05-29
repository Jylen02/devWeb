function load(bool) {
    var newdiv = document.createElement('div');
    newdiv.id = "divlogin";

    var loginButton = document.createElement('a');
    loginButton.id = "login";
    loginButton.classList.add("Connexion");
    loginButton.setAttribute("justify-content", "right");

    var createAccountButton = document.createElement('a');
    createAccountButton.id = "createAccount";
    createAccountButton.classList.add("Connexion");
    createAccountButton.setAttribute("text-align", "right");

    if (bool) {
        loginButton.href = "../profil/logout.php"; // Modifier le lien pour le bouton de déconnexion
        loginButton.innerHTML = "Déconnexion";

        createAccountButton.href = "../profil/settings.php";
        createAccountButton.innerHTML = "Mon profil";
        
        
    } else {
        loginButton.href = "../profil/login.php";
        loginButton.innerHTML = "Connexion";

        createAccountButton.href = "../profil/createAccount.php";
        createAccountButton.innerHTML = "Créer un compte";
        

    }

    newdiv.appendChild(loginButton);
    newdiv.appendChild(createAccountButton);
    document.getElementById('top').appendChild(newdiv);
}

