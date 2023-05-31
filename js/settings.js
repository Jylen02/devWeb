var MaxButton=4;
var nomProfil=['prénom','nom','pseudonyme','addresse e-mail','mot de passe'];

  /*function modify(i) {  
        var profil=['prénom','nom','pseudonyme','adresse e-mail','mot de passe'];
        document.body.setAttribute("class",'modify');
        var newDiv = document.createElement('div');
        newDiv.style.opacity=1;
        var divTitle = document.createElement('div');

        var divTitleMain = document.createElement('div');
        divTitleMain.innerHTML="Changer votre "+profil[i];
        divTitle.appendChild(divTitleMain);
    
        var divTitleSecondary = document.createElement('div');
        divTitleSecondary.innerHTML="Veuillez saisir votre nouveau "+profil[i]+" et votre mot de passe actuel."
        divTitle.appendChild(divTitleSecondary);
    
        var button = document.createElement('button');
        var div = document.createElement('div');
        var svg = document.createElement('svg'); //TODO
        div.appendChild(svg);
        button.appendChild(div);

        var form = document.createElement('form');
        var divForm = document.createElement('div');
    
        var div = document.createElement('div');
        var h2 = document.createElement('h2');
        h2.innerText=profil[i];
        var divBis = document.createElement('div');
        var input = document.createElement('input');
        input.maxLength=100;
        input.type='text';
        divBis.appendChild(input);
        div.appendChild(h2);
        div.appendChild(divBis);
        divForm.appendChild(div);

        var div = document.createElement('div');
        var h2 = document.createElement('h2');
        h2.innerText=profil[4]+" actuel";
        var divBis = document.createElement('div');
        var input = document.createElement('input');
        input.maxLength=100;
        input.type='password';
        divBis.appendChild(input);
        div.appendChild(h2);
        div.appendChild(divBis);
        divForm.appendChild(div);

        var divExit = document.createElement('div');
        var buttonTerminer = document.createElement('button');
        var div = document.createElement('div');
        div.innerHTML='Terminer';
        buttonTerminer.appendChild(div);

        var buttonAnnuler = document.createElement('button');
        var div = document.createElement('div');
        div.innerHTML='Annuler';
        buttonAnnuler.appendChild(div);

        divExit.appendChild(buttonTerminer);
        divExit.appendChild(buttonAnnuler);

        form.appendChild(divForm);
        form.appendChild(divExit);

        newDiv.appendChild(divTitle);
        newDiv.appendChild(form);
        //newDiv.appendChild(document.createTextNode(
        //    <?php // $db='projet'; echo json_encode($db); ?>));
        document.getElementsByTagName('body')[0].appendChild(newDiv);

        document.body.classList.remove('modify');
    }*/
    function modify(i) {
        var profil = ['prénom', 'nom', 'pseudonyme', 'adresse e-mail', 'mot de passe'];
        document.body.classList.add('modify');
    
        // Création du conteneur du pop-up
        var popupContainer = document.createElement('div');
        popupContainer.classList.add('popup-container');
    
        // Création du pop-up
        var popup = document.createElement('div');
        popup.classList.add('popup');
    
        // Titre du pop-up
        var title = document.createElement('div');
        title.innerHTML = "Changer votre " + profil[i];
        popup.appendChild(title);
    
        // Input pour la nouvelle valeur
        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('placeholder', 'Nouvelle ' + profil[i]);
        popup.appendChild(input);
    
        // Input pour le mot de passe actuel
        var passwordInput = document.createElement('input');
        passwordInput.setAttribute('type', 'password');
        passwordInput.setAttribute('placeholder', 'Mot de passe actuel');
        popup.appendChild(passwordInput);
    
        // Bouton pour confirmer
        var confirmButton = document.createElement('button');
        confirmButton.innerText = 'Confirmer';
        confirmButton.addEventListener('click', function() {
            // Récupérer les valeurs des inputs
            var newValue = input.value;
            var password = passwordInput.value;
    
            // Récupérer l'utilisateur correspondant à l'identifiant ou à d'autres critères
            var user = getUserFromDatabase(); // Appeler une fonction pour récupérer les informations de l'utilisateur
    
            // Vérifier si le mot de passe saisi correspond au mot de passe stocké dans la base de données
            if (password === user.motDePasse) {
                // Le mot de passe est correct, procéder à la modification dans la base de données
                updateUserInDatabase(profil[i], newValue);
                
                // Fermer le pop-up
                document.body.removeChild(popupContainer);
                document.body.classList.remove('modify');
            } else {
                // Le mot de passe est incorrect, afficher un message d'erreur ou demander à l'utilisateur de réessayer
                alert("Mot de passe incorrect. Veuillez réessayer.");
            }
        });
        popup.appendChild(confirmButton);
    
        // Bouton pour annuler
        var cancelButton = document.createElement('button');
        cancelButton.innerText = 'Annuler';
        cancelButton.addEventListener('click', function() {
            // Fermer le pop-up
            document.body.removeChild(popupContainer);
            document.body.classList.remove('modify');
        });
        popup.appendChild(cancelButton);
    
        popupContainer.appendChild(popup);
        document.body.appendChild(popupContainer);
    }
    
    function getUserFromDatabase(userName) {
      // Connexion à la base de données
      $connexion = mysqli_connect('localhost', 'nom_utilisateur', 'mot_de_passe', 'nom_base_de_donnees');
    
      // Exécution de la requête SELECT pour récupérer les informations de l'utilisateur
      $command = "SELECT * FROM utilisateur WHERE nom_utilisateur = userName";
      $resultat = mysqli_query($connexion, $command);
    
      // Récupérer le résultat de la requête
      $user = mysqli_fetch_assoc($resultat);
    
      // Fermer la connexion à la base de données
      mysqli_close($connexion);
    
      // Retourner l'utilisateur récupéré
      return $user;
    }
    
    function updateUserInDatabase(field, newValue) {
      // Code pour mettre à jour le champ spécifié dans la base de données avec la nouvelle valeur
    
      // Supposons que vous avez une variable "userId" qui représente l'identifiant de l'utilisateur
      // et une connexion à votre base de données "connexion"
    
      // Construire la requête SQL pour mettre à jour le champ spécifié
      var command = "";
    
      switch (field) {
        case "pseudonyme":
          command = "UPDATE utilisateur SET " + field + " = '" + newValue + "' WHERE identifiant = " + userId;
      }
    
      // Exécuter la requête SQL
      var resultat = mysqli_query(connexion, command);
    
      // Vérifier si la mise à jour s'est effectuée avec succès
      if (resultat) {
        console.log("Le champ '" + field + "' a été mis à jour avec succès !");
      } else {
        console.error("Erreur lors de la mise à jour du champ '" + field + "'.");
      }
    }
    
function click1(request) {
    if (document.getElementsByTagName("input")[0].classList.contains('selected')) {
    } else {
        document.getElementsByTagName("input")[0].classList.add('selected');
        for (let i=1;i<MaxButton;i++) {
            document.getElementsByTagName("input")[i].classList.remove('selected');
        }

        var newDiv = document.createElement('div');
        newDiv.id = 'div1';
        newDiv.classList.add('centerBar');

        var title = document.createElement('h1');
        title.appendChild(document.createTextNode('Mon compte'));
        var account = document.createElement('div').appendChild(title);
        account.id='accountId';
        newDiv.appendChild(account);
        
        var image= document.createElement('img');
        image.src='Onepiece1.webp';
        image.alt='mon image de profil';
        var img = document.createElement('div')
        img.appendChild(image);
        img.id='imageId';
        newDiv.appendChild(img);
        
        var divProfil = document.createElement('div');
        
        for (let i =0;i<5;i++) {
            var divInfo = document.createElement('div');
            divInfo.classList.add('bar');
            var divLabel = document.createElement('div');
            divLabel.classList.add('autre');
            var divLabelsub = document.createElement('div');

            var label1 = document.createElement('h3');
            label1.appendChild(document.createTextNode(nomProfil[i]));
            label1.classList.add('labelChange');

            var label2 = document.createElement('label');
            label2.appendChild(document.createTextNode(request[i]));
            label2.classList.add('labelProfil');

            divLabelsub.appendChild(label1);
            divLabelsub.appendChild(label2);
            divLabel.appendChild(divLabelsub);

            var button = document.createElement('input');
            button.type='button';
            button.value='Modifier';
            button.setAttribute('onclick','modify('+i+')');
            button.classList.add('inputChange');
            if (i==4) {
                button.classList.add('protected');
            }
            divInfo.appendChild(divLabel);
            divInfo.appendChild(document.createElement('div').appendChild(button));

            divProfil.appendChild(divInfo);
        }

        newDiv.appendChild(divProfil);

        var child = document.getElementsByTagName("div")[0].children[1];
        document.getElementsByTagName("div")[0].removeChild(child);
        document.getElementsByTagName("div")[0].appendChild(newDiv);
    }
}

function click2() {
    if (document.getElementsByTagName("input")[1].classList.contains('selected')) {
    } else {
        for (let i=0;i<MaxButton;i++) {
            document.getElementsByTagName("input")[i].classList.remove('selected');
        }
        document.getElementsByTagName("input")[1].classList.add('selected');
        var newDiv = document.createElement('div');
        newDiv.id = 'div2';
        newDiv.classList.add('centerBar');
        
        var newDiv1 = document.createElement('div');
        var newDiv2 = document.createElement('div');

        var title = document.createElement('h1');
        title.appendChild(document.createTextNode("Fonds d'écran :"));
        newDiv.appendChild(title);

        var buttonWhite = document.createElement('input');
        var buttonBlack = document.createElement('input');
    
        buttonWhite.type="button";
        buttonBlack.type="button";

        buttonWhite.value="Fond Blanc";
        buttonBlack.value="Fond Noir";

        buttonWhite.setAttribute('onclick','clickbg("White")');
        buttonBlack.setAttribute('onclick','clickbg("Black")');
        
        newDiv1.appendChild(buttonWhite);
        newDiv2.appendChild(buttonBlack);

        newDiv.appendChild(newDiv1);
        newDiv.appendChild(newDiv2);

        var child = document.getElementsByTagName("div")[0].children[1];
        document.getElementsByTagName("div")[0].removeChild(child);
        document.getElementsByTagName("div")[0].appendChild(newDiv);
    }
}


function click3() {
    if (document.getElementsByTagName("input")[2].classList.contains('selected')) {
    } else {
        for (let i=0;i<MaxButton;i++) {
            document.getElementsByTagName("input")[i].classList.remove('selected');
        }
        document.getElementsByTagName("input")[2].classList.add('selected');
        var newDiv = document.createElement('div');
        newDiv.id = 'div3';
        newDiv.classList.add('centerBar');
        
        var title = document.createElement('h1');
        title.appendChild(document.createTextNode('Mes commentaires :'));
        newDiv.appendChild(title);

        var divSort = document.createElement('div');
        var form = document.createElement('form');
        var select = document.createElement('select'); //trier par dates
        
        var option0 = document.createElement('option');
        option0.value="Tous les commentaires";
        option0.innerHTML="Tous les commentaires";

        var option1 = document.createElement('option');
        option1.value="Aujourd'hui";
        option1.innerHTML="Aujourd'hui";
        
        var option2 = document.createElement('option');
        option2.value="Cette semaine";
        option2.innerHTML="Cette semaine";
        
        var option3 = document.createElement('option');
        option3.value="Ce mois";
        option3.innerHTML="Ce mois";

        var option4 = document.createElement('option');
        option4.value="Cettte année";
        option4.innerHTML="Cette année";

        select.appendChild(option0);
        select.appendChild(option1);
        select.appendChild(option2);
        select.appendChild(option3);
        select.appendChild(option4);
        form.appendChild(select);

        var divBox = document.createElement('div'); //trier par recettes
        var checkbox = document.createElement('input');
        checkbox.type='checkbox';
        var label = document.createElement('label');
        label.innerHTML='Trier par recette';
        
        divBox.appendChild(checkbox);
        divBox.appendChild(label);
        form.appendChild(divBox);
        
        divSort.appendChild(form);
        newDiv.appendChild(divSort);

        var child = document.getElementsByTagName("div")[0].children[1];
        document.getElementsByTagName("div")[0].removeChild(child);
        document.getElementsByTagName("div")[0].appendChild(newDiv);
    }
}


function click4() {
    if (document.getElementsByTagName("input")[3].classList.contains('selected')) {
    } else {
        for (let i=0;i<MaxButton;i++) {
            document.getElementsByTagName("input")[i].classList.remove('selected');
        }
        document.getElementsByTagName("input")[3].classList.add('selected');
        var newDiv = document.createElement('div');
        newDiv.id = 'div4';
        newDiv.classList.add('centerBar');
        
        var title = document.createElement('h1');
        title.appendChild(document.createTextNode('Vos notifications :'));
        newDiv.appendChild(title);

        var child = document.getElementsByTagName("div")[0].children[1];
        document.getElementsByTagName("div")[0].removeChild(child);
        document.getElementsByTagName("div")[0].appendChild(newDiv);
    }
}

function mouseOver(i) {
    document.getElementsByName("button_settings")[i-1].style.backgroundColor="lightblue";
}

function mouseOut(i) {
    document.getElementsByName("button_settings")[i-1].style.backgroundColor="white";
}

function clickbg(i){
    var res=document.body.classList;
    var color=res[0];
    document.body.classList.remove(color);
    document.body.classList.add('bgcolor'+i);
}