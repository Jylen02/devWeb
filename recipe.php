<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recipe</title>
    <link rel="stylesheet" type="text/css" href="recipe.css">
    <script type="text/javascript" src="recipe.js"> </script>
</head>
<body>
    <div>
        <div class="flex">
            <div onload="afficherIngredients(listeIngredients)">
                <h1>Ingrédients</h1>
            </div>
            <div>
                <div>
                    <div align='center'>
                        <img src="Onepiece1.webp" alt="image de la recette"> <br>
                        <div>recette OP</div>
                    </div>
                    <div class="flex">
                        <div>Pour : 2</div>
                        <div>Durée : 5 min</div>
                        <div>Difficulté : Facile</div>
                    </div>
                </div>
                <div onload="afficherRecette(listeRecette)">
                    <h1>Phase technique</h1>
                </div>
            </div>
        </div>
        <div onload="afficherConseils(listeConseils)">
            <h1>Derniers conseils du chef :</h1>
        </div>
    </div>
    <script></script>
</body>
</html>