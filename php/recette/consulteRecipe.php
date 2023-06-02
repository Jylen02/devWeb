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
                            echo "<tr><td><strong>image:</strong></td><td><span><img src='affichageImage.php?id=$value' alt='image' width='150'></span></td><td></td></tr>";
                        } else if ($key === 'image') {
                            echo "";
                        } else {
                            echo "<tr><td><strong>$key:</strong></td><td><span>$value</span></td><td><button onclick=\"modifyRecipe('$idRecette','$key','$value')\">Modifier</button></td></tr>";
                        }
                    }
                }
                echo "</table>";
            } else {
                echo "<script>alert('La recette demandée n\'existe pas.')</script>";
            }
            ?>
        </div>
    </nav>
    <footer>
        <?php
        // Récupération si la recette est en ligne
        $queryValid = "SELECT valid FROM recipe WHERE id = ?";
        $stmt = $connexion->prepare($queryValid);
        $stmt->bind_param("s", $idRecette);
        $stmt->execute();
        $resultValid = $stmt->get_result();
        $row = $resultValid->fetch_assoc();
        if ($row['valid']=='1') {
            echo "<div class=\"center\">";
            echo "<button onclick=\"deleteRecipe()\">Supprimer cette recette</button>";
            echo "</div>";
        }else{
            echo "<div class=\"center\">";
            echo "<button onclick=\"confirmRecipe()\">Confirmer l'upload</button>";
            echo "<button onclick=\"deleteRecipe()\">Supprimer cette recette</button>";
            echo "</div>";
        }
        ?>
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