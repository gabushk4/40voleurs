<?php 
include_once './include/head.php';
include_once './include/nav.php';
include_once 'include/bd.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method == "GET"){
    $_SESSION['message']="";
}

if($method == 'POST'){
    if(isset($_POST['idArticle'])){
        $idArticle = $_POST['idArticle'];
        if(!supprimer_article($idArticle)){
            $_SESSION['message']="impossible de supprimer l'article avec l'id $idArticle; veuilleuz réessayer plus tard";
            
        }
    }
    else{
        $_SESSION['message'] = "impossible de trouver l'article; informations manquantes ou invalides";
    }
}
?>
<h3 class="erreur"><?=$_SESSION['message']?></h3>
<?php 

    if(!$_SESSION['email_confirme']){
        include_once './include/message_demande_conf.php';
    }  
    include_once './include/funcAfficherAnnonce.php';
    include_once './include/bd.php';

    // lire toutes les lignes dans un tableau
    $idUsager = $_SESSION['id'];        

    if(isset($idUsager)){
        try{
            $articles = obtenir_articles_usager($idUsager);
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
            <h3 class='erreur'>Il faut croire que vos informations ne son pas inscrite dans le cookies. Les avez-vous activé?</h3>
        ";
    }
    ?>
    <?php if(count($articles) > 0):?>
    <main class="vitrine">  
        <?php
            foreach ($articles as $article){
                afficherAnnonce($article, false);            
            }
        ?>
    </main>
    <?php else: ?>
        <main>
            <a href='vendre.php'>vendre</a>
        </main>
    <?php 
        endif;

        include './include/footer.php';
    ?>