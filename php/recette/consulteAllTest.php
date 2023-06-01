<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la recette</title>
</head>

<body>
    <?php
    // Vérification si l'ID de la recette a été fourni dans l'URL
    if (isset($_GET['id'])) {
        // Récupération de l'ID de la recette
        $idRecette = $_GET['id'];

        // Connexion à la base de données
        $pdo = new PDO("mysql:host=localhost;dbname=website_database", "projetRecdevweb", "projetRecdevweb2023");

        // Récupération des détails de la recette depuis la table recipeinprocess
        $sql = "SELECT  idUser, id, name, description, image, fornumber, time, difficulty FROM recipeinprocess WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idRecette]);
        $recette = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification si la recette existe
        if ($recette) {
            echo "<ul>";
            foreach ($recette as $key => $value) {
                if ($key === 'idUser') {
                    // Nom d'utilisateur non modifiable
                    echo "<li><strong>{$key}:</strong> {$value}</li>";
                } 
                else if ($key === 'id'){
                    
                    echo "<li><strong>image:</strong> <span><img src='affichageImageAd.php?id=$value' alt='image' width='150'></span> <button class='modify-button'>Modifier</button></li>";
                }
                else if ($key === 'image'){
                    echo "";
                }
                else {
                    echo "<li><strong>{$key}:</strong> <span>{$value}</span> <button class='modify-button'>Modifier</button></li>";
                }
            }
            echo "</ul>";
        } else {
            echo "<p>La recette demandée n'existe pas.</p>";
        }
    } else {
        echo "<p>Erreur : Aucun ID de recette spécifié.</p>";
    }
    ?>

    <footer>
        <button id="confirm-upload">Confirmer l'upload</button>
        <button id="delete-recipe">Supprimer cette recette</button>
    </footer>

    <script>
        const modifyButtons = document.querySelectorAll('.modify-button');

        modifyButtons.forEach(button => {
            button.addEventListener('click', () => {
                const listItem = button.parentNode;
                const valueElement = listItem.querySelector('span');
                const value = valueElement.textContent.trim();
                const input = document.createElement('input');
                input.type = 'text';
                input.value = value;
                listItem.replaceChild(input, valueElement);
                button.textContent = 'Valider';

                button.addEventListener('click', () => {
                    const newValue = input.value;
                    const newValueElement = document.createElement('span');
                    newValueElement.textContent = newValue;
                    listItem.replaceChild(newValueElement, input);
                    button.textContent = 'Modifier';

                    // Effectuer l'enregistrement dans la table recipeinprocess ici
                    const idRecette = <?php echo $idRecette; ?>;
                    const fieldName = valueElement.previousSibling.textContent.trim().replace(':', '');

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'updateRecipe.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            console.log('Modifications enregistrées avec succès');
                        } else {
                            console.log('Erreur lors de l\'enregistrement des modifications');
                        }
                    };
                    xhr.send(`id=${idRecette}&field=${fieldName}&value=${newValue}`);
                });
            });
        });

        const confirmUploadButton = document.getElementById('confirm-upload');
        confirmUploadButton.addEventListener('click', () => {
            // Effectuer la copie des données vers la table recipe et la suppression de la ligne dans la table recipeinprocess ici
            const idRecette = <?php echo $idRecette; ?>;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'confirmUpload.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Upload confirmé avec succès');
                    // Effectuer une redirection ou une autre action souhaitée après la confirmation
                } else {
                    console.log('Erreur lors de la confirmation de l\'upload');
                }
            };
            xhr.send(`id=${idRecette}`);
        });

        const deleteRecipeButton = document.getElementById('delete-recipe');
        deleteRecipeButton.addEventListener('click', () => {
            // Effectuer la suppression de la ligne dans la table recipeinprocess ici
            const idRecette = <?php echo $idRecette; ?>;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'deleteRecipe.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Recette supprimée avec succès');
                    // Effectuer une redirection ou une autre action souhaitée après la suppression
                } else {
                    console.log('Erreur lors de la suppression de la recette');
                }
            };
            xhr.send(`id=${idRecette}`);
        });
    </script>
</body>

</html>
