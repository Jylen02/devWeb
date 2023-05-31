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
  
    var publishButton = document.createElement('a');
    publishButton.id = "publish";
    publishButton.classList.add("Connexion");
    publishButton.setAttribute("justify-content", "right");
    
  
    if (bool) {
      loginButton.href = "../profil/logout.php";
      loginButton.innerHTML = "Déconnexion";
  
      createAccountButton.href = "../profil/settings.php";
      createAccountButton.innerHTML = "Mon profil";
  
      if (username === "admin") {
        publishButton.href = "../recette/consulteRecipe.php";
        publishButton.innerHTML = "Consulter une recette";
        newdiv.appendChild(publishButton);
      }
      else{
        publishButton.href = "../recette/publishedRecipe.php";
        publishButton.innerHTML = "Publier une recette";
        newdiv.appendChild(publishButton);
      }
  
      
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
  