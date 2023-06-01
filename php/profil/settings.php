<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once("../Head.php");
        include_once("../database.php");
        session_start();
        $idUser = $_SESSION['idUser'];
        if (isset($_GET['profil']) && isset($_GET['value'])) {
            // Récupérer les paramètres de l'URL
            $profil = $_GET['profil'];
            $value = $_GET['value'];
        
            // Appeler la fonction updateUserInDatabase avec les valeurs correspondantes
            updateUserInDatabase($profil, $value);
           // Rediriger l'utilisateur vers la page "settings"
            header("Location: settings.php");
            exit;
        } else if (isset($_GET['deleteProfil']) && $_GET['deleteProfil']==1){
            deleteUser();
            header("Location: ../accueil/home.php");
            exit;
        } else if (isset($_GET['deleteComment'])){
            $i = $_GET['deleteComment'];
            deleteComment($i);
            header("Location: settings.php");
            exit;
        }
        function updateUserInDatabase($field, $newValue) {
            global $idUser, $connexion;
            // Code pour mettre à jour le champ spécifié dans la base de données avec la nouvelle valeur
        
            // Supposons que vous avez une variable "userId" qui représente l'identifiant de l'utilisateur
            // et une connexion à votre base de données "connexion"
        
            // Construire la requête SQL pour mettre à jour le champ spécifié
            $command = "";
        
            switch ($field) {
            case "nom d'utilisateur":
                $command = "UPDATE user SET username = '$newValue' WHERE username = '$idUser'";
                $_SESSION['idUser'] = $newValue;
                break;
            case "adresse e-mail":
                $command = "UPDATE user SET mail = '$newValue' WHERE username = '$idUser'";
                break;
            case "mot de passe":
                $command = "UPDATE user SET password = '$newValue' WHERE username = '$idUser'";
                break;
            }
        
            // Exécuter la requête SQL
            $resultat = mysqli_query($connexion, $command);
            
            // Vérifier si la mise à jour s'est effectuée avec succès
            if ($resultat) {
                echo "<script>alert('Le champ \"$field\" a été mis à jour avec succès !');</script>";
            } else {
                echo "<script>alert('Erreur lors de la mise à jour du champ \"$field\".');</script>";
            }
        }

        function deleteUser() {
            global $idUser, $connexion;
            $command1 = "DELETE FROM recipe WHERE idUser = '$idUser' ";

            // Exécuter la requête SQL
            $resultat1 = mysqli_query($connexion, $command1);

            $command2 = "DELETE FROM evaluation WHERE idUser = '$idUser' ";

            // Exécuter la requête SQL
            $resultat2 = mysqli_query($connexion, $command2);

            $command3 = "DELETE FROM recipeinprocess WHERE idUser = '$idUser' ";

            // Exécuter la requête SQL
            $resultat3 = mysqli_query($connexion, $command3);
            
            $command = "DELETE FROM user WHERE username = '$idUser' ";

            // Exécuter la requête SQL
            $resultat = mysqli_query($connexion, $command);
            
            // Vérifier si la mise à jour s'est effectuée avec succès
            if ($resultat) {
                echo "<script>alert('Le compte a été supprimé avec succès !');</script>";
                unset($_SESSION['idUser']);
            } else {
                echo "<script>alert('Erreur lors de la suppression du compte.');</script>";
            }
        }

        function deleteComment($i) {
            global $idUser, $connexion;
            $command = "DELETE FROM evaluation WHERE idUser = '$idUser' AND id = '$i'";

            // Exécuter la requête SQL
            $resultat = mysqli_query($connexion, $command);

             // Vérifier si la mise à jour s'est effectuée avec succès
             if ($resultat) {
                echo "<script>alert('Le commentaire a été supprimé avec succès !');</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression du commentaire.');</script>";
            }
        }
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/settings.css">
    <script>
        var MaxButton=4;
        function modify(i, resultat) {
            var profil = ['nom d\'utilisateur', 'adresse e-mail', 'mot de passe'];
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
                var user = resultat; // Appeler une fonction pour récupérer les informations de l'utilisateur
        
                console.log(password);
                console.log(user.password);
                // Vérifier si le mot de passe saisi correspond au mot de passe stocké dans la base de données
                if (password === user.password) {
                    // Fermer le pop-up
                    document.body.removeChild(popupContainer);
                    document.body.classList.remove('modify');
                    
                    // Le mot de passe est correct, procéder à la modification dans la base de données
                    window.location.href = 'settings.php?profil=' + encodeURIComponent(profil[i]) + '&value=' + encodeURIComponent(newValue);
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
        
        function click1(resultat) {
            if (!document.getElementsByTagName("input")[0].classList.contains('selected')) {
                document.getElementsByTagName("input")[0].classList.add('selected');
                for (let i = 1; i < MaxButton; i++) {
                    document.getElementsByTagName("input")[i].classList.remove('selected');
                }
        
                var newDiv = document.createElement('div');
                newDiv.id = 'div1';
                newDiv.classList.add('centerBar');
        
                var title = document.createElement('h3');
                title.appendChild(document.createTextNode('Mon compte'));
                var account = document.createElement('div');
                account.appendChild(title);
                account.id='accountId';
                newDiv.appendChild(account);
        
                var image = document.createElement('img');
                image.alt = 'Photo de profil';
        
                // Assurez-vous que le champ 'profilePicture' est correctement récupéré dans $resUser
                // Supposons que le champ 'profilePicture' contienne la chaîne Base64
                var profilePictureData = resultat.profilePictures;
                image.src = 'data:image/jpeg;base64,' + profilePictureData;
        
                var img = document.createElement('div');
                img.appendChild(image);
                img.id = 'imageId';
                newDiv.appendChild(img);
        
                var divProfil = document.createElement('div');
        
                var nomProfil = ['Nom d\'utilisateur', 'Email', 'Mot de passe', 'Score', 'Commentaires activés'];
        
                for (let i = 0; i < 5; i++) {
                    var divInfo = document.createElement('div');
                    divInfo.classList.add('bar');
                    var divLabel = document.createElement('div');
                    divLabel.classList.add('autre');
                    var divLabelsub = document.createElement('div');
        
                    var label1 = document.createElement('h3');
                    label1.appendChild(document.createTextNode(nomProfil[i]));
                    label1.classList.add('labelChange');
        
                    var label2 = document.createElement('label');
                    var value = '';
                    switch (i) {
                        case 0:
                            value = resultat.username;
                            break;
                        case 1:
                            value = resultat.mail;
                            break;
                        case 2:
                            value = '*****'; // Vous pouvez masquer le mot de passe si vous le souhaitez
                            break;
                        case 3:
                            value = resultat.score;
                            break;
                        case 4:
                            value = resultat.enableComment ? 'Activés' : 'Désactivés';
                            break;
                    }
                    label2.appendChild(document.createTextNode(value));
                    label2.classList.add('labelProfil');
        
                    divLabelsub.appendChild(label1);
                    divLabelsub.appendChild(label2);
                    divLabel.appendChild(divLabelsub);
        
                    if (i<3){
                        var button = document.createElement('input');
                        button.type = 'button';
                        button.value = 'Modifier';
                        button.setAttribute('onclick', 'modify(' + i + ', ' + JSON.stringify(resultat) + ')');
                        button.classList.add('inputChange');
                        divInfo.appendChild(divLabel);
                        divInfo.appendChild(document.createElement('div').appendChild(button));
                        divProfil.appendChild(divInfo);
                        newDiv.appendChild(divProfil);
                    } else {
                        divInfo.appendChild(divLabel);
                        divProfil.appendChild(divInfo);
                        newDiv.appendChild(divProfil);
                    }
        
                    if (i == 2) {
                        button.classList.add('protected');
                    }
        
                }
                // Bouton de suppression de compte
                var deleteButton = document.createElement('input');
                deleteButton.type = 'button';
                deleteButton.value = 'Supprimer le compte';
                deleteButton.classList.add('deleteButton');
                deleteButton.addEventListener('click', function() {
                    window.location.href = 'settings.php?deleteProfil=1';
                });
                newDiv.appendChild(deleteButton);
        
                var child = document.getElementsByTagName("div")[0].children[1];
                document.getElementsByTagName("div")[0].removeChild(child);
                document.getElementsByTagName("div")[0].appendChild(newDiv);
            }
        }
        
        function click2() {
            if (!document.getElementsByTagName("input")[1].classList.contains('selected')) {
                for (let i = 0; i < MaxButton; i++) {
                    document.getElementsByTagName("input")[i].classList.remove('selected');
                }
                document.getElementsByTagName("input")[1].classList.add('selected');
                var newDiv = document.createElement('div');
                newDiv.id = 'div2';
                newDiv.classList.add('centerBar');
        
                var title = document.createElement('h1');
                title.appendChild(document.createTextNode("Fonds d'écran :"));
                newDiv.appendChild(title);
        
                var buttonWhite = document.createElement('input');
                var buttonBlack = document.createElement('input');
        
                buttonWhite.type = "button";
                buttonBlack.type = "button";
        
                buttonWhite.value = "Fond Blanc";
                buttonBlack.value = "Fond Noir";
        
                buttonWhite.setAttribute('onclick', 'clickbg("White")');
                buttonBlack.setAttribute('onclick', 'clickbg("Black")');
        
                newDiv.appendChild(buttonWhite);
                newDiv.appendChild(buttonBlack);
        
                var child = document.getElementsByTagName("div")[0].children[1];
                document.getElementsByTagName("div")[0].removeChild(child);
                document.getElementsByTagName("div")[0].appendChild(newDiv);
            }
        }
        
        function click3(resultatCommentaires) {
            var resultatCommentairesOriginal = resultatCommentaires.slice();
            if (!document.getElementsByTagName("input")[2].classList.contains('selected')) {
                for (let i = 0; i < MaxButton; i++) {
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
                option0.value = "Tous les commentaires";
                option0.innerHTML = "Tous les commentaires";
            
                var option1 = document.createElement('option');
                option1.value = "Aujourd'hui";
                option1.innerHTML = "Aujourd'hui";
            
                var option2 = document.createElement('option');
                option2.value = "Cette semaine";
                option2.innerHTML = "Cette semaine";
            
                var option3 = document.createElement('option');
                option3.value = "Ce mois";
                option3.innerHTML = "Ce mois";
            
                var option4 = document.createElement('option');
                option4.value = "Cette année";
                option4.innerHTML = "Cette année";
            
                select.appendChild(option0);
                select.appendChild(option1);
                select.appendChild(option2);
                select.appendChild(option3);
                select.appendChild(option4);
                form.appendChild(select);
            
                var divBox = document.createElement('div'); //trier par recettes
                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                var label = document.createElement('label');
                label.innerHTML = 'Trier par recette';
            
                function updateCommentDiv(resultatCommentaires) {
                    // Supprimer les commentaires existants
                    var existingComments = document.getElementsByClassName('comment');
                    while (existingComments.length > 0) {
                        existingComments[0].parentNode.removeChild(existingComments[0]);
                    }
                
                    // Ajouter les commentaires à la div
                    for (let i = 0; i < resultatCommentaires.length; i++) {
                        let commentaire = resultatCommentaires[i].comment;
                        let score = resultatCommentaires[i].score;
                
                        let commentDiv = document.createElement('div');
                        commentDiv.classList.add('comment');
                
                        let commentText = document.createElement('p');
                        commentText.innerHTML = commentaire;
                
                        let scoreText = document.createElement('p');
                        scoreText.innerHTML = "Score: " + score;
                
                        var deleteButton = document.createElement('input');
                        deleteButton.type = 'button';
                        deleteButton.value = 'Supprimer le commentiare';
                        deleteButton.classList.add('deleteButton');
                        deleteButton.addEventListener('click', function() {
                            window.location.href = 'settings.php?deleteComment=' + resultatCommentaires[i].id;
                        });

                        commentDiv.appendChild(commentText);
                        commentDiv.appendChild(scoreText);
                        commentDiv.appendChild(deleteButton);
                
                        newDiv.appendChild(commentDiv);
                    }
                }
        
                // Ajouter un écouteur d'événement sur le checkbox
                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        // Tri des commentaires par ID de recette
                        resultatCommentaires.sort(function(a, b) {
                        var idA = a.idRecipe;
                        var idB = b.idRecipe;
                    
                        // Comparaison des ID de recette
                        if (idA < idB) {
                        return -1;
                        } else if (idA > idB) {
                        return 1;
                        } else {
                        return 0;
                        }
                    });
                    
                    // Mettre à jour l'affichage avec les commentaires triés
                    updateCommentDiv(resultatCommentaires);
                    } else {
                        // Réinitialiser l'ordre des commentaires à leur ordre d'origine
                        resultatCommentaires = resultatCommentairesOriginal.slice();
                        // Mettre à jour l'affichage avec les commentaires non triés
                        updateCommentDiv(resultatCommentaires);
                    }
                });
        
                divBox.appendChild(checkbox);
                divBox.appendChild(label);
                form.appendChild(divBox);
            
                divSort.appendChild(form);
                newDiv.appendChild(divSort);
        
                select.addEventListener('change', function() {
                    var selectedOption = select.value;
        
                    // Filtrage des commentaires par date
                    var filteredComments = [];
                    if (selectedOption === "Aujourd'hui") {
                        var today = new Date().toLocaleDateString();
                        filteredComments = resultatCommentaires.filter(function(comment) {
                            var commentDate = new Date(comment.date).toLocaleDateString();
                            return commentDate === today;
                        });
                    } else if (selectedOption === "Cette semaine") {
                        var currentDate = new Date();
                        var startOfWeek = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() - currentDate.getDay());
                        var endOfWeek = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() - currentDate.getDay() + 6);
                        
                        filteredComments = resultatCommentaires.filter(function(comment) {
                            var commentDate = new Date(comment.date);
                            return commentDate >= startOfWeek && commentDate <= endOfWeek;
                        });
                    } else if (selectedOption === "Ce mois") {
                        var currentDate = new Date();
                        var startOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), currentDate.getDate() - currentDate.getDay());
                        var endOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() , currentDate.getDate() - currentDate.getDay() + 30);
                        
                        filteredComments = resultatCommentaires.filter(function(comment) {
                            var commentDate = new Date(comment.date);
                            return commentDate >= startOfMonth && commentDate <= endOfMonth;
                        });
                    } else if (selectedOption === "Cette année") {
                        var currentYear = new Date().getFullYear();
                        var startOfYear = new Date(currentYear, 0, 1);
                        var endOfYear = new Date(currentYear, 11, 31);
                        
                        filteredComments = resultatCommentaires.filter(function(comment) {
                            var commentDate = new Date(comment.date);
                            return commentDate >= startOfYear && commentDate <= endOfYear;
                        });
                    } else {
                        // Pas de filtrage par date, afficher tous les commentaires
                        filteredComments = resultatCommentaires;
                    }
        
                    // Supprimer les commentaires existants
                    var existingComments = document.getElementsByClassName('comment');
                    while (existingComments.length > 0) {
                        existingComments[0].parentNode.removeChild(existingComments[0]);
                    }
        
                    // Ajouter les commentaires à la div
                    for (let i = 0; i < filteredComments.length; i++) {
                        let commentaire = filteredComments[i].comment;
                        let score = filteredComments[i].score;
                        
                        let commentDiv = document.createElement('div');
                        commentDiv.classList.add('comment');
        
                        let commentText = document.createElement('p');
                        commentText.innerHTML = commentaire;
        
                        let scoreText = document.createElement('p');
                        scoreText.innerHTML = "Score: " + score;

                        var deleteButton = document.createElement('input');
                        deleteButton.type = 'button';
                        deleteButton.value = 'Supprimer le commentiare';
                        deleteButton.classList.add('deleteButton');
                        deleteButton.addEventListener('click', function() {
                            window.location.href = 'settings.php?deleteComment=' + filteredComments[i].id;
                        });
        
                        commentDiv.appendChild(commentText);
                        commentDiv.appendChild(scoreText);
                        commentDiv.appendChild(deleteButton);

                        newDiv.appendChild(commentDiv);
                    }
                });
                updateCommentDiv(resultatCommentaires);
                var child = document.getElementsByTagName("div")[0].children[1];
                document.getElementsByTagName("div")[0].removeChild(child);
                document.getElementsByTagName("div")[0].appendChild(newDiv);
            }
        }
        
        function click4() {
            if (!document.getElementsByTagName("input")[3].classList.contains('selected')) {
                for (let i = 0; i < MaxButton; i++) {
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
            document.getElementsByName("button_settings")[i - 1].style.backgroundColor = "lightblue";
        }
        
        function mouseOut(i) {
            document.getElementsByName("button_settings")[i - 1].style.backgroundColor = "white";
        }
        
        function clickbg(i) {
            var res = document.body.classList;
            var color = res[0];
            document.body.classList.remove(color);
            document.body.classList.add('bgcolor' + i);
        }  
    </script>
</head>
<body class="bgcolorWhite">
    <?php
        // Préparation de la requête avec un paramètre lié
        $requeteUser = "SELECT * FROM user WHERE username = ?";
        $stmt = $connexion->prepare($requeteUser);

        // Liaison du paramètre et exécution de la requête
        $stmt->bind_param("s", $idUser);
        $stmt->execute();

        // Récupération des résultats
        $resultat = $stmt->get_result();

        // Récupération de la première ligne de résultats
        $resUser = $resultat->fetch_assoc();

        // Préparation de la requête pour récupérer les commentaires de l'utilisateur
        $requeteCommentaires = "SELECT * FROM evaluation WHERE idUser = ?";
        $stmtCommentaires = $connexion->prepare($requeteCommentaires);

        // Liaison du paramètre et exécution de la requête
        $stmtCommentaires->bind_param("s", $idUser);
        $stmtCommentaires->execute();

        // Récupération des résultats des commentaires
        $resCommentaires = $stmtCommentaires->get_result();

        // Récupération de tous les commentaires dans un tableau
        $commentaires = array();
        while ($rowCommentaire = $resCommentaires->fetch_assoc()) {
            $commentaires[] = $rowCommentaire;
        }

        // Fermeture de la requête (le résultat sera utilisé plus tard)
        $stmtCommentaires->close();

        // Fermeture de la requête et de la connexion
        $stmt->close();
        $connexion->close();

    ?>
    <div class="bar" id="main">
    <div role="tablist" class="leftBar" align="right">
        <div tabindex="-2" class="retourAccueil">
            <a href="../accueil/home.php" id="retourAccueil">
            ← Accueil
            </a>
        </div>
        <div tabindex="-1" role="button">Paramètres utilisateur</div>
        <div>
            <script>  var resUser = <?php echo json_encode($resUser); 
            $resUser['profilePictures'] = base64_encode($resUser['profilePictures']);?>; </script>
            <input tabindex="0" type="button" name="button_settings" value="profil" class="input" 
            onclick="click1(resUser)" onmouseover="mouseOver(1)" onmouseout="mouseOut(1)">
        </div>
        <div>
            <input tabindex="-1" type="button" name="button_settings" value="accessibilité" class="input" 
            onclick="click2()" onmouseover="mouseOver(2)" onmouseout="mouseOut(2)">
        </div>
        <div>
            <script> var resComment = <?php echo json_encode($commentaires); ?>; </script>
            <input tabindex="-1" type="button" name="button_settings" value="commentaires" class="input" 
            onclick="click3(resComment)" onmouseover="mouseOver(3)" onmouseout="mouseOut(3)">
        </div>
        <div>
            <input tabindex="-1" type="button" name="button_settings" value="notifications" class="input" 
            onclick="click4()" onmouseover="mouseOver(4)" onmouseout="mouseOut(4)">
        </div>
    </div>

    <script>
        var resUser = <?php echo json_encode($resUser); 
        $resUser['profilePictures'] = base64_encode($resUser['profilePictures']);?>;
        click1(resUser);
    </script>
</body>
</html>
