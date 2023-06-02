<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include_once("../Head.php");
    include_once("../database.php");
    session_start();
    ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/consulteRecipe.css">

</head>

<body>
    <div>
        <h1 class="center">Détails de la recette</h1>
    </div>
    <nav>
        <div class="center">
            <?php
            // Vérification si l'ID de la recette a été fourni dans l'URL
            if (isset($_GET['id'])) {
                // Récupération de l'ID de la recette
                $idRecette = $_GET['id'];

                // Récupération des détails de la recette depuis la table recipe
                $queryRecipe = "SELECT idUser, id, name, description, image, fornumber, time, difficulty FROM recipe WHERE id = ?";
                $stmt = $connexion->prepare($queryRecipe);
                $stmt->bind_param("s", $idRecette);
                $stmt->execute();
                $resultRecipe = $stmt->get_result();

                // Vérification si la recette existe
                if ($resultRecipe && $resultRecipe->num_rows > 0) {
                    echo "<table cellspacing=10 cellpadding=10>";
                    $recipe = $resultRecipe->fetch_assoc();
                    foreach ($recipe as $key => $value) {
                        if ($key === 'idUser') {
                            // Nom d'utilisateur non modifiable
                            echo "<tr><td><strong>$key:</strong></td><td>$value</td><td></td></tr>";
                        } else if ($key === 'id') {
                            echo "<tr><td><strong>image:</strong></td><td><span><img src='affichageImageAd.php?id=$value' alt='image' width='150'></span></td><td></td></tr>";
                        } else if ($key === 'image') {
                            echo "";
                        } else {
                            echo "<tr><td><strong>$key:</strong></td><td><span>$value</span></td><td><button onclick=\"modifyRecipe('$idRecette','$key','$value')\">Modifier</button></td></tr>";
                        }
                    }
                    echo "</table>";
                } else {
                    echo "<script>alert('La recette demandée n\'existe pas.')</script>";
                }
            } else {
                echo "<script>alert('Erreur : Aucun ID de recette spécifié.')</script>";
            }
            ?>
        </div>
    </nav>
    <footer>
        <div class="center">
            <button onclick="confirmRecipe()">Confirmer l'upload</button>
            <button onclick="deleteRecipe()">Supprimer cette recette</button>
        </div>
    </footer>
    <script>
        function modifyRecipe(idRecipe, key, value) {
            const newValue = prompt("Entrez la nouvelle valeur :", value);
            if (newValue !== null) {
                var xhr = new XMLHttpRequest();
                var url = "updateRecipe.php";
                var params = "idRecipe=" + encodeURIComponent(idRecipe) + "&key=" + encodeURIComponent(key) + "&newValue=" + encodeURIComponent(newValue);

                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            alert(xhr.responseText); // Succès
                            window.location.href = 'consulteRecipe.php?id=' + encodeURIComponent(<?php echo $idRecette; ?>);
                        } else {
                            alert("Une erreur s'est produite lors de la modification."); // Erreur
                        }
                    }
                };

                xhr.send(params);
            }
        }

        function confirmRecipe() {
            var xhr = new XMLHttpRequest();
            var url = "confirmRecipe.php";
            var params = "idRecipe=" + encodeURIComponent(<?php echo $idRecette; ?>);

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        alert(xhr.responseText); // Succès
                        window.location.href = 'consulteAllRecipe.php';
                    } else {
                        alert("Une erreur s'est produite lors de la confirmation."); // Erreur
                    }
                }
            };

            xhr.send(params);
        }

        function deleteRecipe() {
            var xhr = new XMLHttpRequest();
            var url = "deleteRecipe.php";
            var params = "idRecipe=" + encodeURIComponent(<?php echo $idRecette; ?>);

            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        alert(xhr.responseText); // Succès
                        window.location.href = 'consulteAllRecipe.php';
                    } else {
                        alert("Une erreur s'est produite lors de la confirmation."); // Erreur
                    }
                }
            };

            xhr.send(params);
        }


    </script>
    <footer>
        <div class="center">
            <?php
            if (isset($_SESSION['idUser'])) {
                echo '<a href="../recette/consulteAllRecipe.php">← Retour</a>';
            } else {
                echo '<a href="../accueil/home.php?success=0">Connexion</a>';
            }
            ?>
        </div>
    </footer>

</body>

</html>