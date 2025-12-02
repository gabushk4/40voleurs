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
<form class="demande-conf">
    <p>Tu dois confirmer ton courriel</p>
    <div style="width:200px;height:32px">
        <button class="btn-normal" href="">cliques ici pour confirmer</button>
    </div>
   
</form>
<main class="vitrine">    
        <?php
            include_once './include/funcAfficherAnnonce.php';
            include_once './include/bd.php';

            // lire toutes les lignes dans un tableau
            $idUsager = $_SESSION['id'];
            

            if(isset($idUsager)){
                try{
                    $articles = obtenir_articles_usager($idUsager);
                    if(count($articles) > 0){
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