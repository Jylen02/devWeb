document.getElementById("barreRecherche").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        // Récupérer la valeur de l'input
        var recherche = document.getElementById("barreRecherche").value;
        alert(recherche);

        //Connexion de la BDD
        

        // Récuperer depuis la BDD les tags et afficher un format titre + note
        

        // Afficher la recette selectionnée


        // Poster un commentaire
    }
});