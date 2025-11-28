<?php 
include './include/head.php';
include './include/nav.php';
?>

<main class="vitrine">
        <?php
            include_once './include/funcAfficherAnnonce.php';
            include_once './include/bd.php';

            // lire toutes les lignes dans un tableau
            $idUsager = $_SESSION['id'];

            if(isset($idUsager)){
                try{
                    $articles = obtenir_articles_usager($idUsager);
                    if(isset($articles)){
                        foreach ($articles as $article){
                            afficherAnnonce($article, false);            
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
            }else{
                echo "
                    <h3 class='erreur'>Il faut croire que vos informations ne son pas isncrite dans le cookies. Les avez-vous activé?</h3>
                ";
            }
        ?>
    </main>

<?php
include './include/footer.php';
?>