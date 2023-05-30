<!DOCTYPE html>
<html lang="fr">  
<head>
    <?php
        include_once("../Head.php");
    ?>
    <link rel="stylesheet"
    type="text/css"
    href="../../css/home.css">
    <script src="../../js/home.js" type="text/javascript">
    </script>
</head>

<body>
    <header>
        <h2> Evaluation de la recette </h2>
    </header>

    <section>
        <?php
        // Vérification si l'ID de la recette est passé en paramètre dans l'URL
        if (isset($_GET['id'])) {
            $idRecette = $_GET['id'];

            // Vérification de l'état de connexion de l'utilisateur
            session_start();
            if (isset($_SESSION['idUser'])) {
                $idUser = $_SESSION['idUser'];

                // Traitement du formulaire d'évaluation
                if (isset($_POST['score']) && isset($_POST['comment'])) {
                    $score = $_POST['score'];
                    $commentaire = $_POST['comment'];

                    // Connexion à la base de données
                    $serveur = "localhost";
                    $utilisateur = "projetRecdevweb";
                    $motDePasse = "projetRecdevweb2023";
                    $baseDeDonnees = "website_database";

                    $connexion = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDeDonnees);

                    // Vérification de la connexion à la base de données
                    if (!$connexion) {
                        die("Connexion à la base de données échouée : " . mysqli_connect_error());
                    }

                    // Vérification si l'utilisateur a déjà laissé un commentaire pour cette recette
                    $requeteVerification = "SELECT * FROM evaluation WHERE idUser = '$idUser' AND idRecipe = '$idRecette'";
                    $resultatVerification = mysqli_query($connexion, $requeteVerification);

                    if (mysqli_num_rows($resultatVerification) > 0) {
                        // L'utilisateur a déjà laissé un commentaire pour cette recette
                        echo "<script>alert('Vous avez déjà laissé un commentaire pour cette recette.');</script>";
                    } else {
                        // Requête SQL pour insérer l'évaluation dans la table "evaluation"
                        $requeteEvaluation = "INSERT INTO evaluation (score, comment, idUser, idRecipe) VALUES ('$score', '$commentaire', '$idUser', '$idRecette')";
                        $resultatEvaluation = mysqli_query($connexion, $requeteEvaluation);

                        if ($resultatEvaluation) {
                            // Succès de l'enregistrement
                            echo "<script>alert('L\'évaluation a été enregistrée avec succès!');</script>";
                        } else {
                            // Erreur lors de l'enregistrement
                            echo "<script>alert('Une erreur est survenue lors de l\'enregistrement de l\'évaluation. Veuillez réessayer.');</script>";
                        }
                    }

                    // Fermeture de la connexion à la base de données
                    mysqli_close($connexion);

                    // Redirection vers la page detailsRecette.php
                    echo "<script>window.location.href = 'detailsRecette.php?id=$idRecette';</script>";
                    exit();
                }

                // Affichage du formulaire d'évaluation
                echo "
                    <form method='POST' action='evaluation.php?id=$idRecette'>
                        <label for='score'>Score :</label><br>
                        <input type='radio' name='score' value='1'>1
                        <input type='radio' name='score' value='2'>2
                        <input type='radio' name='score' value='3'>3
                        <input type='radio' name='score' value='4'>4
                        <input type='radio' name='score' value='5'>5
                        <br><br>
                        <label for='comment'>Commentaire :</label><br>
                        <textarea name='comment' rows='4' cols='50'></textarea>
                        <br><br>
                        <input type='submit' value='Confirmer'>
                    </form>
                ";
            } else {
                // L'utilisateur n'est pas connecté, redirection vers la page de connexion
                echo "<script>alert('Vous devez être connecté pour laisser un commentaire.');</script>";
                echo "<script>window.location.href = '../profil/login.php';</script>";
                exit();
            }
        }/* else {
            // L'ID de la recette n'est pas passé en paramètre dans l'URL, redirection vers une page d'erreur
            echo "<script>window.location.href = 'erreur.php';</script>";
            exit();
        }*/
        ?>
    </section>
    <footer>
        <div>
            <a href="detailsRecette.php?id=<?php echo $idRecette; ?>"> ← Retour</a>
        </div>
    </footer>

</body>
</html>
