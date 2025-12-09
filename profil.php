<?php 
include_once './include/head.php';
include_once './include/nav.php';
include_once 'include/bd.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method == "GET"){
    $_SESSION['message']="";
}


?>
<h3 class="erreur"><?=$_SESSION['message']?></h3>
<?php 

    if(isset($_SESSION['email_confirme'])&&!$_SESSION['email_confirme']){
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
    <?php 
        if(count($articles) > 0):
            $id_usager = $_SESSION['id'];
            $informations_usager = obtenir_informations_profil($id_usager);  
            $nom_en_bd = $informations_usager["nom"];
            $prenom_en_bd = $informations_usager["prenom"];
            $courriel_en_bd = $informations_usager["courriel"];  
    ?>
    <main class="page-profil">
        <div class="vitrine-profil">  
            <?php
                foreach ($articles as $article){
                    afficherAnnonce($article, false, true);            
                }
            ?>
        </div>
        <div>
            <fieldset class="fieldset">
            <legend>informations du profil</legend>
            <form class="form-perso">
                <div class="form-ligne">
                    <label for="nom">nom</label>    
                    <input type="text" name="nom" id="nom" value="<?=$nom_en_bd?>"/>
                </div>
                <div class="form-ligne">
                    <label for="nom">prenom</label>    
                    <input type="text" name="nom" id="nom" value="<?=$prenom_en_bd?>"/>
                </div>
                <div class="form-ligne">
                    <label for="nom">courriel</label>    
                    <input type="text" name="nom" id="nom" value="<?=$courriel_en_bd?>"/>
                </div>
                <div class="form-ligne"> 
                    <a href="modifier_mdp.php" class="">modifier le mot de passe</a>
                </div>
                <div class="form-ligne" style="height:56px">
                    <button type="reset" class="btn-normal" style="width:48%; font-size: 24px;">
                        annuler
                    </button>
                    <button type="submit" class="btn-imp" style="width:48%; font-size: 24px;">
                        modifier
                    </button>
                </div>            
            </form>
            </fieldset>
        </div>
    </main>
    <?php else: ?>
        <main>
            <a href='vendre.php'>vendre</a>
        </main>
    <?php 
        endif;

        include './include/footer.php';
    ?>