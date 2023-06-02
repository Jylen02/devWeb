function load(bool, username) {
    var newdiv = document.createElement('div');
    newdiv.id = "divlogin";
  
    var divinfo = document.createElement('div');
    divinfo.id = "divinfo";

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

    var productButton = document.createElement('a');
    productButton.id = "product";
    productButton.classList.add("Connexion");
    productButton.setAttribute("justify-content", "right");

    if (bool) {

      loginButton.href = "../profil/logout.php";
      loginButton.innerHTML = "Déconnexion";
  
      createAccountButton.href = "../profil/settings.php";
      createAccountButton.innerHTML = "Mon profil";
      newdiv.appendChild(loginButton);
      divinfo.appendChild(createAccountButton);
  
      if (username == "admin") {
        publishButton.href = "../recette/consulteRecipe.php";
        publishButton.innerHTML = "Recette";

        productButton.href = "../recette/produit.php";
        productButton.innerHTML = "Produits";

        divinfo.appendChild(publishButton);
        divinfo.appendChild(productButton);
      }
      else{
        publishButton.href = "../recette/publishedRecipe.php";
        publishButton.innerHTML = "Recette";
        
        divinfo.appendChild(publishButton);
      }
      
    document.getElementById('top').appendChild(newdiv);
    document.getElementById('top2').appendChild(divinfo);
    } else {
      loginButton.href = "../profil/login.php";
      loginButton.innerHTML = "Connexion";
  
      createAccountButton.href = "../profil/createAccount.php";
      createAccountButton.innerHTML = "Créer un compte";
      
      newdiv.appendChild(loginButton);
      newdiv.appendChild(createAccountButton);
      
      var vide = document.createElement('a');
      divinfo.appendChild(vide);

    document.getElementById('top').appendChild(newdiv);
    document.getElementById('top2').appendChild(divinfo);
    }
  
  }
  