<?php include "./include/head.php"?>
    <div class="header-image"></div>
    <?php include "./include/nav.php" ?>
    </header>
    <main class="vitrine">
        <?php
            define("URL", "https://prog101.com/cours/kb9/bd/annonces.csv");
            @ $annoncesF = fopen('./data.csv', 'r');

            if($annoncesF){
                include './include/funcAfficherAnnonce.php';
                $annonces = [];

            // lire toutes les lignes dans un tableau
            while (($annonce = fgetcsv($annoncesF, 0, '|')) !== false) {
                $annonces[] = $annonce;
            }
            fclose($annoncesF);

            // inverser l'ordre
            $annonces = array_reverse($annonces);

            // afficher
            foreach ($annonces as $annonce) {
                afficherAnnonce($annonce);
            }
            }else {
                echo <<<FIN
                    Votre commande ne peut être traitée<br>
                    Veuillez S.V.P. essayer plus tard
                FIN;
                exit(1); // termine immédiatement le programme
            }
        ?>
    </main>
<?php include './include/footer.php'?>