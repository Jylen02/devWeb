<?php
include_once("../database.php");
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idUser'])) {
    header("Location: ../profil/login.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $idUser = $_SESSION['idUser'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $fornumber = $_POST['fornumber'];
    $time = $_POST['time'];
    $difficulty = $_POST['difficulty'];
    $date = date("Y-m-d");

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['tmp_name'];
        
        // Chemin de destination pour stocker l'image
        $destination = "../../image/" . $_FILES['image']['name'];
        
        // Déplacer l'image vers le répertoire de destination
        move_uploaded_file($image, $destination);
        
        // Stocker le chemin de l'image dans la variable $image
        $image = $destination;
    } else {
        $image = null;
    }

    // Connexion à la base de données et insertion des données dans la table "recipe"

    // Insérer les données de la recette dans la table "recipe"
    $insertRecipe = "INSERT INTO recipe (name, description, image, publishedDate, idUser, fornumber, time, difficulty) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtRecipe = $connexion->prepare($insertRecipe);
    $stmtRecipe->bind_param("ssssssss", $name, $description, $image, $date, $idUser, $fornumber, $time, $difficulty);
    $stmtRecipe->execute();


    if ($stmtRecipe->affected_rows > 0) {
        // Une nouvelle ligne a été insérée avec succès
        echo "Nouvelle ligne insérée dans la table recipe.";
        // Récupérer l'ID de la recette insérée
        $idRecipe = $stmtRecipe->insert_id;
        // Insérer les ingrédients de la recette dans la table "product"
        $ingredients = $_POST['ingredient_name'];
        $quantities = $_POST['ingredient_quantity'];
        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = $ingredients[$i];
            $quantity = $quantities[$i];
            $insertProduct = "INSERT INTO product (idRecipe, name, amount) VALUES (?, ?, ?)";
            $stmtProduct = $connexion->prepare($insertProduct);
            $stmtProduct->bind_param("sss", $idRecipe, $ingredient, $quantity);
            $stmtProduct->execute();
            if ($stmtProduct->affected_rows > 0) {
                // Une nouvelle ligne a été insérée avec succès
                echo "Nouvelle ligne insérée dans la table recipe.";
            } else {
                // Aucune ligne insérée (erreur ou aucune modification)
                echo "Aucune ligne insérée dans la table recipe." . $stmtProduct->error;
            }
        }

        // Calculer et mettre à jour le prix dans la table "recipe"
        $updatePriceRecipe = "UPDATE recipe 
            SET price = ( 
                    SELECT SUM( productlist.price * product.amount ) 
                    FROM product 
                    JOIN productlist ON productlist.name = product.name 
                    WHERE product.idRecipe = ? 
                        ) 
            WHERE id = ?;";
        $stmtPriceRecipe = $connexion->prepare($updatePriceRecipe);
        $stmtPriceRecipe->bind_param("ss", $idRecipe, $idRecipe);
        $stmtPriceRecipe->execute();
        header("Location: ../accueil/home.php?success=1");
    } else {
        // Aucune ligne insérée (erreur ou aucune modification)
        echo "Aucune ligne insérée dans la table recipe." . $stmtRecipe->error;
        header("Location: publishedRecipe.php");
    }
    $connexion->commit();

    // Succès de l'enregistrement
    echo "<script>alert('La publication s'est faite avec succès!');</script>";
    // Redirection vers une page de confirmation ou une autre action souhaitée

    exit;
}
?>