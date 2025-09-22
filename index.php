<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./style.css?v=1.0" rel="stylesheet">
        <link rel="icon" type="image/png" href="./assets/brand.png">
        <script defer src="./script.js"></script>
        <title>Les quarante voleurs</title>        
        
    </head>
    <body>
        <header>
            <div class="header-image"></div>
            <?php include "./include/nav.php" ?>
        </header>
        <main>
            <?php
                define("TITRE_I",0);
                define("DESCRIPTION_I", 1);
                define("PRIX_I",2);
                define("NEGOCIABLE_I",3);
                define("IMAGE_I",4);
                define("AUTEUR_I",5);
                @ $annoncesF = fopen('./data/annonces.csv', 'r');

                if($annoncesF){
                    while(!feof($annoncesF)){
                        $annonce = fgetcsv($annoncesF, null, ':');
                        if(is_array($annonce)){
                            $negociable = $annonce[NEGOCIABLE_I] == "oui" ? "Négociable" : "Non négociable";
                            echo '<div class="annonce">
                                    <img src="./assets/'.$annonce[IMAGE_I].'"/>
                                    <div class="annonce-texte-conteneur">
                                        <h2>'.$annonce[TITRE_I].'</h2>
                                        <h3>'.$annonce[DESCRIPTION_I].'</h3>
                                        <div class="annonce-soustexte-conteneur">
                                            <p>'.$annonce[PRIX_I].'$</p>
                                            <p>'.$negociable.'</p>
                                            <p>'.$annonce[AUTEUR_I].'</p>
                                        </div>
                                    </div>
                                </div>';

                        }else{
                            echo <<<EOF
                                <div class="annonce">
                                    <img src=""/>
                                    <h2>Annonce non chargée</h2>
                                    <p>erreur</p>
                                    <p>erreur</p>
                                    <p>erreur</p>
                                    <p>erreur</p>
                                </div>
                            EOF;
                        }
                        
                    }
                    fclose($annoncesF);
                }else {
                    echo <<<FIN
                        Votre commande ne peut être traitée<br>
                        Veuillez S.V.P. essayer plus tard
                    FIN;
                    exit(1); // termine immédiatement le programme
                }
            ?>
        </main>
    </body>
</html>