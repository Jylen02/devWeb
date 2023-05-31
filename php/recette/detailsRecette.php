<!DOCTYPE html>
<html lang="fr">  
<head>
    <?php include_once("../Head.php");?>
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
    <link rel="stylesheet" type="text/css" href="../../css/detailsRecette.css">
    <script src="../../js/home.js" type="text/javascript">
    </script>


</head>
    <body>       
        <header>
            <div class="recette-details">
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

                // Vérification si l'ID de la recette est passé en paramètre dans l'URL
                if (isset($_GET['id'])) {
                    $idRecette = $_GET['id'];

                    // Requête SQL pour récupérer tous les attributs de la recette
                    $requeteRecette = "SELECT name, description, image, time, fornumber, difficulty, price FROM recipe WHERE id = $idRecette";
                    $resultatRecette = mysqli_query($connexion, $requeteRecette);
                    // Requête SQL pour calculer la moyenne des scores
                    $requeteMoyenneScore = "SELECT AVG(score) AS moyenne_score FROM evaluation WHERE idRecipe = $idRecette";
                    $resultatMoyenneScore = mysqli_query($connexion, $requeteMoyenneScore);
                    $rowMoyenneScore = mysqli_fetch_assoc($resultatMoyenneScore);
                    $moyenneScore = number_format($rowMoyenneScore['moyenne_score']);

                    if (mysqli_num_rows($resultatRecette) > 0) {
                        $rowRecette = mysqli_fetch_assoc($resultatRecette);
                        $titre = $rowRecette['name'];
                        $description = $rowRecette['description'];
                        $image = $rowRecette['image'];
                        $time = $rowRecette['time'];
                        $fornumber = $rowRecette['fornumber'];
                        $difficulty = $rowRecette['difficulty'];
                        $price = $rowRecette['price'];

                        // Affichage des détails de la recette
                        //echo "<h3>$titre</h3>";
                        //echo "<aside><p>$description</p></aside>";
                        //echo "<header><img src='affichageImage.php?id=$idRecette' alt='$titre' width='200'></header>";
                    } else {
                        echo "Aucune recette trouvée.";
                    }
                    
                    // Libération des résultats de la requête de la recette
                    mysqli_free_result($resultatRecette);
                }
                
                
                echo "<h1>$titre</h1>
                <header><img src='affichageImage.php?id=$idRecette' alt='$titre' width='200'></header>";
                echo "<div class='align'>";
                echo "<div class='recette-details-item'><span>Pour :</span> <span>$fornumber</span></div>";
                echo "<div class='recette-details-item'><span>coût estimé :</span> <span>$price euros</span></div>";
                echo "<div class='recette-details-item'><span>Durée :</span> <span>$time heure</span></div>";
                echo "<div class='recette-details-item'><span>Difficulté :</span> <span>$difficulty</span></div>";
                echo "</div>";
                    
                // Fermeture de la connexion à la base de données
                mysqli_close($connexion);
                ?>
            </div>
        
        </header>

        <aside>
            <?php
                echo "<aside> Description de la recette :
                <p>$description</p></aside>";             
            ?>
        </aside>
        <footer>
            <div>
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

            echo "<h3 style='color: red;'>Note : $moyenneScore/5 
                (<a href='scoreRecette.php?id=$idRecette'> voir les commentaires</a> /
                <a href='evaluation.php?id=$idRecette' class='evaluer-button'>évaluer</a> la recette - $titre -)
                </h3><br>";

            // Fermeture de la connexion à la base de données
            mysqli_close($connexion);
            ?>
        </div>
            
        <div>
            <?php
                session_start();
                if (isset($_SESSION['idUser'])) {
                    echo ' <a href="../accueil/home.php?success=1">← Retour</a>';

                } else {
                    echo '<a href="../accueil/home.php?success=0">Connexion</a>';
                }
                ?>
                
            </div>
        </footer>
    </body>
</html>