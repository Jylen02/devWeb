function changePrice(price, name) {
    var newPrice = prompt("Veuillez entrer le nouveau prix :", price);

    if (newPrice !== null) {
        var xhr = new XMLHttpRequest();
        var url = "changePrice.php";
        var params = "newPrice=" + encodeURIComponent(newPrice) + "&name=" + encodeURIComponent(name);

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert(xhr.responseText); // Succès
                    updatePrice(name);
                    window.location.href = 'produit.php';

                } else {
                    alert("Une erreur s'est produite lors de la modification du prix."); // Erreur
                }
            }
        };

        xhr.send(params);
    }
}

function updatePrice(name) {
    var xhr = new XMLHttpRequest();
    var url = "updatePrices.php";
    var params = "name=" + encodeURIComponent(name);
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert(xhr.responseText); // Succès
                window.location.href = 'produit.php';

            } else {
                alert("Une erreur s'est produite lors de la modification du prix."); // Erreur
            }
        }
    };

    xhr.send(params);
}

function deleteIngredient(name) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette ligne ?")) {
        var xhr = new XMLHttpRequest();
        var url = "deleteIngredient.php";
        var params = "name=" + encodeURIComponent(name);

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    alert(xhr.responseText); // Succès
                    window.location.href = 'produit.php';
                } else {
                    alert("Une erreur s'est produite lors de la suppression de la ligne."); // Erreur
                }
            }
        };

        xhr.send(params);
    }
}

function addIngredient() {
    var name = prompt("Veuillez entrer le nom de l'ingrédient :");
    var price = prompt("Veuillez entrer le prix de l'ingrédient :");

    if (name && price) {
        var xhr = new XMLHttpRequest();
        var url = "addIngredient.php";
        var params = "name=" + encodeURIComponent(name) + "&price=" + encodeURIComponent(price);

        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var newRow = "<tr><td>" + name + "</td><td>" + price + "</td><td><button onclick='modifierPrix(" + price + ", \"" + name + "\")'>Modifier prix</button></td><td><button onclick='supprimerLigne(\"" + name + "\")'>Supprimer</button></td></tr>";
                    var table = document.querySelector("table");
                    var tbody = table.querySelector("tbody");
                    tbody.insertAdjacentHTML("beforeend", newRow);
                    alert(xhr.responseText); // Succès
                } else {
                    alert("Une erreur s'est produite lors de l'ajout de l'ingrédient."); // Erreur
                }
            }
        };

        xhr.send(params);
    }
}
