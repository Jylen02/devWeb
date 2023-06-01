<?php
session_start();
include_once("../database.php");
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idUser'])) {
    header("Location: ../profil/login.php");
}
// Vérification si l'utilisateur est l'administrateur
if ($_SESSION['idUser'] === 'admin') {
    // Rediriger l'administrateur vers la page de consultation des recettes
    header("Location: consulteRecipe.php");
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

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['tmp_name'];

        // Copier l'image dans un répertoire de destination
        $destination = "../../image" . $_FILES['image']['name'];
        move_uploaded_file($image, $destination);
    } else {
        $image = null;
    }

    // Connexion à la base de données et insertion des données dans la table "recipeinprocess"

    try {
        // Insérer les données de la recette dans la table "recipeinprocess"
        $insertRecipeProcess = "INSERT INTO recipeinprocess (name, description, image, idUser, fornumber, time, difficulty) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connexion->prepare($insertRecipeProcess);
        $stmt->bind_param("ssbssss", $name, $description, $image, $idUser, $fornumber, $time, $difficulty);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Une nouvelle ligne a été insérée avec succès
            echo "Nouvelle ligne insérée dans la table recipeinprocess.";
        } else {
            // Aucune ligne insérée (erreur ou aucune modification)
            echo "Aucune ligne insérée dans la table recipeinprocess." . $connexion->error;

        }
        // Récupérer l'ID de la recette insérée
        $recipeId = $connexion->insert_id;

        // Insérer les ingrédients de la recette dans la table "product"
        $ingredients = $_POST['ingredient_name'];
        $quantities = $_POST['ingredient_quantity'];

        for ($i = 0; $i < count($ingredients); $i++) {
            $ingredient = $ingredients[$i];
            $quantity = $quantities[$i];

            $insertProduct = "INSERT INTO product (idRecipe, name, amount) VALUES (?, ?, ?)";
            $stmt = $connexion->prepare($insertProduct);
            $stmt->bind_param("sss", $recipeId, $ingredient, $quantity);
            $stmt->execute();
        }

        // Calculer et mettre à jour le prix dans la table "recipeinprocess"
        $updatePriceRecipeProcess = "UPDATE recipeinprocess 
            SET price = ( 
                    SELECT SUM( productlist.price * product.amount ) 
                    FROM product 
                    JOIN productlist ON productlist.name = product.name 
                    WHERE product.idRecipe = ? 
                        ) 
            WHERE id = ?;";
        $stmt = $connexion->prepare($updatePriceRecipeProcess);
        if (!$stmt) {
            // Afficher l'erreur de la base de données
            echo "Erreur de préparation de la requête : " . $connexion->error;
            exit;
        }
        $stmt->bind_param("ss", $recipeId, $recipeId);
        $stmt->execute();

        $connexion->commit();

        // Succès de l'enregistrement
        echo "<script>alert('La publication s'est faite avec succès!');</script>";
        // Redirection vers une page de confirmation ou une autre action souhaitée
        if (isset($_SESSION['idUser'])) {
            echo "<script>window.location.href = '../accueil/home.php?success=1';</script>";
        } else {
            echo "<script>window.location.href = '../accueil/home.php?success=0';</script>";
        }
    } catch (PDOException $e) {
        // Erreur lors de l'enregistrement
        $connexion->rollback();
        echo "<script>alert('Une erreur est survenue lors de l'enregistrement de la publication. Veuillez réessayer.');</script>";
    }

    exit;
}
?>