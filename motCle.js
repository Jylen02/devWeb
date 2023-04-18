function rechercheMotCleMultiple(listeDesTermes,motsCle) {    //listeDesTermes = listes des recettes (ou liste des paramètres)
                                                //en mode chaque mot Cle réduit le nombre de choix; 
    var res=new Array();
    var index=0;
    var tab=new Array();
    var indexTab=0;
    var tabCle=new Array();
    var indexCle=0;
    
    tabCle=motsCle.split(" ");

    for (let i=0;i<tabCle.length;i++) {
        tabCle[i]=transformeMot(tabCle[i]);
    }

    for (let i=0;i<listeDesTermes.length;i++) {
        var str=listeDesTermes[i];
        
        tab[i]=str.split(" ");
        for (let j=0;j<tab[i].length;j++) {
            tab[i][j] = transformeMot(tab[i][j]);
        }

        var comp=0;
        var indexMot=0;
        var mot=tab[i][indexMot];
        
        while (indexCle<tabCle.length && indexMot<tab[i].length) {
            if (motAvecErreur(mot,tabCle[indexCle])) {
                comp++;
                indexCle++;
                indexMot=0;
                mot=tab[i][indexMot];
            } else {
                indexMot++;
                mot=tab[i][indexMot];
            }
        }
        if (comp==tabCle.length) {
            res[index]=listeDesTermes[i];
            index++;        
        }
    }
    alert(res);
}

function rechercheMotCleUnique(listeDesTermes,motCle) {    //listeDesTermes = listes des recettes (ou liste des paramètres)
    var res=new Array();
    var index=0;
    var tab=new Array();
    motCle=transformeMot(motCle);

    for (let i=0;i<listeDesTermes.length;i++) {
        var str=listeDesTermes[i];
        tab[i]=str.split(" ");
        for (let j=0;j<tab[i].length;j++) {     //mettre un while à la place
            var mot = tab[i][j];
            mot=transformeMot(mot);
            
            if (motMoinsProche(mot,motCle)) { // Version utilisant la fonction motMoinsProche
                res[index]=listeDesTermes[i];
                index++;
            }
        }
    }
    alert(res);
}

function motIdentiques(mot,motCle) {
    if (mot==motCle) {
        return true;
    }
    return false;
}

function motAvecErreur(mot,motCle) {
    var nbErreur=1+Math.floor(motCle.length/10);
    var i=0;
    var j=0;

    if (mot.length<motCle.length-nbErreur || mot.length>motCle.length+nbErreur) {
        return false;
    }    return motAvecErreurRec(mot,motCle,nbErreur,i,j);
}

function motAvecErreurRec(mot,motCle,nbErreur,i,j) {
    var res=false;
    if (nbErreur<0) {
        return false;
    }
    if (i>mot.length && j>motCle.length) {
        return true;
    }

    if (mot[i]==motCle[j]) {
        res=res || motAvecErreurRec(mot,motCle,nbErreur,i+1,j+1);
    } else {
        if (mot[i]==motCle[j+1] && mot[i+1]==motCle[j]) {           // inversion de caractères consécutifs dans le mot clé
            res=res || motAvecErreurRec(mot,motCle,nbErreur-1,i+2,j+2);
        }
        if (mot[i+1]=motCle[j]) {                                   // oublis d'un caractère dans le mot clé
            res=res || motAvecErreurRec(mot,motCle,nbErreur-1,i+2,j+1);
        }
        if (mot[i]=motCle[j+1]) {                                   // ajout d'un caractère dans le mot clé
            res=res || motAvecErreurRec(mot,motCle,nbErreur-1,i+1,j+2);
        }
    }

    return res;
}

function transformeMot(mot) {
    var listeLettreSpe = ['é','è','ê','ë','à','â','î','ï','ô','ù','û','ü','ÿ','ç','æ','œ'];
    var listeLettre = ['e','e','e','e','a','a','i','i','o','u','u','u','y','c','ae','oe'];

    mot=mot.toLowerCase();

    for (let i=0;i<mot.length;i++) {
        var lettre = mot[i];
        let j=0;

        while (lettre != listeLettreSpe[j] && j<listeLettreSpe.length) {
            j++;
        }
        
        if (j<listeLettreSpe.length-2) {
            mot=mot.replace(mot[i],listeLettre[j]);
        } else if (j==listeLettreSpe.length-2 || j==listeLettreSpe.length-1) {
            mot=mot.substring(0,i)+listeLettre[j]+mot.substring(i+1,mot.length-i);
        }
    }
    return mot;
}

//rechercheMotCleMultiple(['Les choux à la crème','Des carottes à la vapeur','Le boeuf bourgignon','Les carottes rapées','les crêpes'],'cartottés vapeur a');
//rechercheMotCleUnique(['Les choux à la crème','Des carottes à la vapeur','Le boeuf bourgignon','Les carottes rapées','les crêpes'],'cartottés');