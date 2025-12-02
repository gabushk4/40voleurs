<?php include "./include/head.php"?>
    <div class="header-image"></div>
    <?php include "./include/nav.php";
        
        if(isset($_SESSION['email_confirme'])&&!$_SESSION['email_confirme']){
            include_once './include/message_demande_conf.php';
        }
    ?>
    <main class="vitrine">
        <?php
            include_once './include/funcAfficherAnnonce.php';
            include_once './include/bd.php';
            // lire toutes les lignes dans un tableau
            try{
                $articles = obtenir_articles($idCategorie);
                if(isset($articles)){
                    foreach ($articles as $article){
                        afficherAnnonce($article);            
                    }
                }
                else{
                    echo "C'est vide ici";
                }
            }catch(Exception $e){
            
                echo <<<FIN
                    Votre commande ne peut être traitée<br>
                    Veuillez S.V.P. essayer plus tard
                    ($e)
                FIN;
                exit(1); // termine immédiatement le programme
            }
        ?>
    </main>
<?php include './include/footer.php'?>