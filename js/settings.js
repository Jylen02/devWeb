var MaxButton=4;
var nomProfil=['prénom','nom','pseudonyme','addresse e-mail','mot de passe'];


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