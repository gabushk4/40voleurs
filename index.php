<?php include "./include/head.php"?>
    <div class="header-image"></div>
    <?php include "./include/nav.php" ?>
    </header>
    <main class="vitrine">
        <?php
            define("URL", "https://prog101.com/cours/kb9/bd/annonces.csv");
            @ $annoncesF = fopen(URL, 'r');

            if($annoncesF){
                include './include/funcAfficherAnnonce.php';
                while(!feof($annoncesF)){
                    $annonce = fgetcsv($annoncesF, null, '|');
                    afficherAnnonce($annonce);
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
<?php include './include/footer.php'?>