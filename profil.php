<?php 
include_once './include/head.php';
include_once './include/nav.php';
include_once 'include/bd.php';
include_once 'include/funcValeurCorrecte.php';

$method = $_SERVER['REQUEST_METHOD'];
$erreur = null;
$succes = null;
$idUsager = $_SESSION['id'];

if($method == "GET"){
    $_SESSION['message']="";
}
if($method == "POST"){
    $valide = true;
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $courriel = $_POST["courriel"];

    if(!ValeurCorrecte(strlen($prenom), 2, 50)){
        $valide = false;
        $erreur = "le prenom doit être entre 2 et 50 caractères";
    }
    else if(!ValeurCorrecte(strlen($nom), 2, 50)){
        $valide = false;
        $erreur = "le nom doit être entre 2 et 50 caractères";
    }
    else if(!ValeurCorrecte(strlen($courriel), 6, 254)){
        $valide = false;
        $erreur = "l'adresse courriel doit être entre 6 et 254 caractères";
    }

    if($valide){
        $statut = modifier_usager($nom, $prenom, $courriel, $idUsager);
        if(!$statut[0])
            $erreur = $statut[1];
        else
            $succes = "informations modifiées !";
    }
}

    $informations_usager = obtenir_informations_profil($idUsager);  
    $nom_en_bd = $informations_usager["nom"];
    $prenom_en_bd = $informations_usager["prenom"];
    $courriel_en_bd = $informations_usager["courriel"];  

    if(isset($_SESSION['email_confirme'])&&!$_SESSION['email_confirme']){
        include_once './include/message_demande_conf.php';
    }  
    
    include_once './include/funcAfficherAnnonce.php';
    include_once './include/bd.php';

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
        header("Location: index.php");
        exit;
    }
    ?>
    <?php 
        if(count($articles) > 0):            
    ?>
    <main class="main-horizontal">
        <div class="vitrine-profil">  
            <?php
                foreach ($articles as $article){
                    afficherAnnonce($article, false, true);            
                }
            ?>
        </div>
        <div>
            <p class="erreur"><?=$erreur??''?></p>
            <fieldset class="fieldset">
            <legend>informations du profil</legend>
            <form class="form-perso" method="POST">
                <div class="form-ligne">
                    <label for="nom">nom</label>    
                    <input type="text" name="nom" id="nom" value="<?=$nom_en_bd?>"/>
                </div>
                <div class="form-ligne">
                    <label for="prenom">prenom</label>    
                    <input type="text" name="prenom" id="prenom" value="<?=$prenom_en_bd?>"/>
                </div>
                <div class="form-ligne">
                    <label for="courriel">courriel</label>    
                    <input type="email" name="courriel" id="courriel" value="<?=$courriel_en_bd?>"/>
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
            <p class="succes"><?=$succes??''?></p>
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