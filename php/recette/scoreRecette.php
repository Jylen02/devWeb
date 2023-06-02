<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include_once("../Head.php"); ?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/imageSetting.css">
    <script src="../../js/home.js" type="text/javascript"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires de la recette</title>
</head>

<body>
    <header>
            <?php 
            include_once("../database.php");
            session_start();
            if (isset($_GET['id'])) {
                $idRecette = $_GET['id'];
                $req = "SELECT name, score FROM recipe WHERE id = $idRecette";
                $resulte = mysqli_query($connexion, $req);
                if (mysqli_num_rows($resulte) > 0) {
                    $rowTT = mysqli_fetch_assoc($resulte);
                    $score = $rowTT["score"];
                    $name = $rowTT["name"];
                    echo "<h1>Commentaires de la recette : $name - score: <span class=\"score-red\">$score</span>/5</h1>";
                } else {
                    echo "Aucune recette trouvée.";
                }
            }
        ?>
        <div class='sorting'>
        <form method="POST">

            <select name="tri" onchange="this.form.submit()">
                <option value="">Trier les commentaires</option>
                <option value="note_croissante">Note croissante</option>
                <option value="note_decroissante">Note décroissante</option>
                <option value="date_publication">Date de publication</option>
            </select>
        </form>
    </div>
    </header>

    <?php
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

    // Récupération de l'ID de la recette depuis l'URL
    if (isset($_GET['id'])) {
        $idRecette = $_GET['id'];

        // Traitement du formulaire de tri
        if (isset($_POST['tri'])) {
            $tri = $_POST['tri'];

            // Modifier votre requête SQL en fonction du tri sélectionné
            if ($tri === 'note_croissante') {
                $requeteCommentaires = "SELECT c.comment, c.score, c.date, u.username, u.profilePictures
                                        FROM evaluation AS c
                                        INNER JOIN user AS u ON c.idUser = u.username
                                        WHERE c.idRecipe = $idRecette
                                        ORDER BY c.score ASC, c.date ASC";
            } elseif ($tri === 'note_decroissante') {
                $requeteCommentaires = "SELECT c.comment, c.score, c.date, u.username, u.profilePictures
                                        FROM evaluation AS c
                                        INNER JOIN user AS u ON c.idUser = u.username
                                        WHERE c.idRecipe = $idRecette
                                        ORDER BY c.score DESC";
            } elseif ($tri === 'date_publication') {
                $requeteCommentaires = "SELECT c.comment, c.score, c.date, u.username, u.profilePictures
                                        FROM evaluation AS c
                                        INNER JOIN user AS u ON c.idUser = u.username
                                        WHERE c.idRecipe = $idRecette
                                        ORDER BY c.date ASC";
            }
        } else {
            // Requête SQL par défaut sans tri spécifié
            $requeteCommentaires = "SELECT c.comment, c.score, c.date, u.username, u.profilePictures
                                    FROM evaluation AS c
                                    INNER JOIN user AS u ON c.idUser = u.username
                                    WHERE c.idRecipe = $idRecette";
        }

        // Exécution de la requête des commentaires
        $resultatCommentaires = mysqli_query($connexion, $requeteCommentaires);

        if (mysqli_num_rows($resultatCommentaires) > 0) {
            // Affichage des commentaires
            while ($rowCommentaire = mysqli_fetch_assoc($resultatCommentaires)) {
                $commentaire = $rowCommentaire['comment'];
                $utilisateur = $rowCommentaire['username'];
                $score = $rowCommentaire['score'];
                $photoProfil = $rowCommentaire['profilePictures'];
                $datePublication = $rowCommentaire['date'];

                echo "<div class='commentaire'>";
                echo "<div class='user-info'>";
                echo "<img src='affichageAvatar.php?id=$utilisateur' width='40'>";
                echo "<p><strong>$utilisateur :</strong> - $datePublication </p>";
                echo "Note : ($score/5) - $commentaire";
                echo "</div>";
                echo "</div><br>";
            }
        } else {
            echo "<p>Aucun commentaire trouvé.</p>";
        }

        // Libération des résultats de la requête des commentaires
        mysqli_free_result($resultatCommentaires);
    } else {
        echo "<p>Aucune recette spécifiée.</p>";
    }

    // Fermeture de la connexion à la base de données
    mysqli_close($connexion);
    ?>

    
    <footer>
        <div>
            <a href="../accueil/home.php" id="retourAccueil">
                ← Accueil
            </a>
        </div>
    </footer>
</body>

</html>