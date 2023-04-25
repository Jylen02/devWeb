function load(bool){
    if (bool){
        newdiv = document.createElement('div');
        newdiv.id = "divlogin";
        loginButton = document.createElement('a');
        loginButton.href="home.php";
        loginButton.id = "login";
        loginButton.classList.add("Connexion");
        loginButton.setAttribute("justify-content","right");
        loginButton.innerHTML = "Déconnexion";
        createAccountButton = document.createElement('a');
        createAccountButton.href="settings.php";
        createAccountButton.id = "createAccount";
        createAccountButton.classList.add("Connexion");
        createAccountButton.setAttribute("text-align","right");
        createAccountButton.innerHTML = "Mon profil";
        newdiv.appendChild(loginButton);
        newdiv.appendChild(createAccountButton);
        document.getElementById('top').appendChild(newdiv);
    }else{
        newdiv = document.createElement('div');
        newdiv.id = "divlogin";
        loginButton = document.createElement('a');
        loginButton.href="login.php";
        loginButton.id = "login";
        loginButton.classList.add("Connexion");
        loginButton.setAttribute("justify-content","right");
        loginButton.innerHTML = "Connexion";
        createAccountButton = document.createElement('a');
        createAccountButton.href="createAccount.php";
        createAccountButton.id = "createAccount";
        createAccountButton.classList.add("Connexion");
        createAccountButton.setAttribute("text-align","right");
        createAccountButton.innerHTML = "Créer un compte";
        newdiv.appendChild(loginButton);
        newdiv.appendChild(createAccountButton);
        document.getElementById('top').appendChild(newdiv);
    }
}