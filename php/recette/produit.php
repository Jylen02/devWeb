<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include_once("../Head.php");
    include_once("../database.php");
    session_start();
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <script> var username = "<?php echo isset($_SESSION['idUser']) ? $_SESSION['idUser'] : ''; ?>"; </script>
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        td:nth-last-child(-n+2) {
            border: transparent;
        }
    </style>
</head>

<body>
    <h1>Liste des produits</h1>

    <?php
    // Récupérer les données de la table productList
    $queryProduct = "SELECT name, price FROM productList";
    $result = $connexion->query($queryProduct);

    if ($result->num_rows > 0) {
        // Afficher le tableau si des données sont disponibles
        echo "<table><tbody>";
        echo "<tr><th>Ingrédient</th><th>Prix</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["name"] . "</td><td>" . $row["price"] . "</td><td><button onclick='modifierPrix(" . $row["price"] . ", \"" . $row["name"] . "\")'>Modifier prix</button></td><td><button onclick='supprimerIngredient(\"" . $row["name"] . "\")'>Supprimer</button></td></tr>";
        }
        echo "</tbody></table>";
        echo "<button onclick='ajouterIngredient()'>Ajouter ingrédient</button>";

    } else {
        echo "Aucun produit trouvé dans la base de données.";
    }

    // Fermer la connexion à la base de données
    $connexion->close();
    ?>
    <script>
        function modifierPrix(price, name) {
            var newPrice = prompt("Veuillez entrer le nouveau prix :", price);

            if (newPrice !== null) {
                var xhr = new XMLHttpRequest();
                var url = "modifierPrix.php";
                var params = "newPrice=" + encodeURIComponent(newPrice) + "&name=" + encodeURIComponent(name);

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
        }

        function supprimerIngredient(name) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette ligne ?")) {
                var xhr = new XMLHttpRequest();
                var url = "supprimerIngredient.php";
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

        function ajouterIngredient() {
            var name = prompt("Veuillez entrer le nom de l'ingrédient :");
            var price = prompt("Veuillez entrer le prix de l'ingrédient :");

            if (name && price) {
                var xhr = new XMLHttpRequest();
                var url = "ajouterIngredient.php";
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

    </script>
</body>

</html>