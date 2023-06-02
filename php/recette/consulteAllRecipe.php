<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/consulteRecipe.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la recette</title>
    <?php
    include_once("../database.php");
    session_start();
    ?>
    
</head>

<body>
    <nav>
        <div class="center">
            <?php
            // Vérification si l'ID de la recette a été fourni dans l'URL
            if (isset($_GET['id'])) {
                // Récupération de l'ID de la recette
                $idRecette = $_GET['id'];

                // Récupération des détails de la recette depuis la table recipeinprocess
                $sql = "SELECT idUser, id, name, description, image, fornumber, time, difficulty FROM recipeinprocess WHERE id = '$idRecette'";
                $result = $connexion->query($sql);

                // Vérification si la recette existe
                if ($result && $result->num_rows > 0) {
                    echo "<table cellspacing=10 cellpadding=10>";
                    $recette = $result->fetch_assoc();
                    foreach ($recette as $key => $value) {
                        if ($key === 'idUser') {
                            // Nom d'utilisateur non modifiable
                            echo "<tr><td><strong>{$key}:</strong></td><td>{$value}</td><td></td></tr>";
                        } else if ($key === 'id') {
                            echo "<tr><td><strong>image:</strong></td><td><span><img src='affichageImageAd.php?id=$value' alt='image' width='150'></span></td><td></td></tr>";
                        } else if ($key === 'image') {
                            echo "";
                        } else {
                            echo "<tr><td><strong>{$key}:</strong></td><td><span>{$value}</span></td><td><button class='modify-button'>Modifier</button></td></tr>";
                        }
                    }
                    echo "</table>";
                } else {
                    echo "<script>alert('La recette demandée n\'existe pas.')</script>";
                }
                
                // recuperation des ingrédients liée à cette recette
                $sqlb= "SELECT name, amount FROM product WHERE idRecipe='$idRecette'";
                $resultb = $connexion->query($sql);
                if ($resultb && $result->num_rows > 0) {
                    echo "<table cellspacing=10 cellpadding=10>";
                    echo "<tr><td><strong>Ingredient</strong></td><td>Quantité</td><td></td></tr>";
                    echo "</table>";
                    
                }
                else {
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
            <button id="confirm-upload">Confirmer l'upload</button>
            <button id="delete-recipe">Supprimer cette recette</button>
        </div>
    </footer>

    <script>
        const modifyButtons = document.querySelectorAll('.modify-button');

        modifyButtons.forEach(button => {

            button.addEventListener('click', () => {
                const listItem = button.parentNode.parentNode;
                const valueElement = listItem.querySelector('span');
                const value = valueElement.textContent.trim();

                const newValue = prompt("Entrez la nouvelle valeur :", value);

                if (newValue !== null) {
                    const fieldName = valueElement.previousElementSibling.textContent.replace(':', '');
                    const idRecette = <?php echo $idRecette; ?>;

                    const data = {
                        id: idRecette,
                        field: fieldName,
                        value: newValue
                    };

                    fetch('updateRecipe.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                alert(result.message);
                                valueElement.textContent = newValue;
                            } else {
                                alert(result.message);
                            }
                        })
                        .catch(error => {
                            console.error('Une erreur s\'est produite:', error);
                        });
                }
            });
        });

        document.getElementById('confirm-upload').addEventListener('click', () => {
            if (confirm('Confirmer l\'upload de cette recette ?')) {
                const idRecette = <?php echo $idRecette; ?>;

                const data = {
                    id: idRecette
                };

                fetch('confirmeUploade.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(() => {
                        alert('Upload confirmé avec succès');
                        window.location.href = 'consulteRecipe.php';
                    })
                    .catch(error => {
                        console.error('Une erreur s\'est produite:', error);
                    });
            }
        });

        document.getElementById('delete-recipe').addEventListener('click', () => {
            if (confirm('Supprimer cette recette ?')) {
                const idRecette = <?php echo $idRecette; ?>;

                const data = {
                    id: idRecette
                };

                fetch('deleteRecipe.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(() => {
                        alert('La recette a été supprimée avec succès');
                        window.location.href = 'consulteRecipe.php';
                    })
                    .catch(error => {
                        console.error('Une erreur s\'est produite:', error);
                    });
            }
        });
    </script>
    <footer>
        <div class="center">
            <?php
            if (isset($_SESSION['idUser'])) {
                echo '<a href="../recette/consulteRecipe.php">← Retour</a>';
            } else {
                echo '<a href="../accueil/home.php?success=0">Connexion</a>';
            }
            ?>
        </div>
    </footer>

</body>

</html>
