<?php
    include_once 'include/head.php';
    include_once 'include/nav.php';
    $erreurCategorie = $_SESSION['erreur_categories']??'';
    $succesCategorie = $_SESSION['succes_categories']??'';

    $_SESSION['erreur_categories'] = '';
    $_SESSION['succes_categories'] = '';

    include_once "./include/bd.php";

    $erreurUsagers = $_SESSION['erreur_usagers']??'';
    $succesUsagers = $_SESSION['succes_usagers']??'';

    $_SESSION['erreur_usagers'] = '';
    $_SESSION['succes_usagers'] = '';

    $usagers = obtenir_tous_usagers();
    if(!$usagers[0]){
        $erreurUsagers = $usager[1];
    }

?>
<main class="main-form" style="gap:32px">
    <fieldset style="width:40%">
        <legend>catégories</legend>
        <p class="erreur"><?=$erreurCategorie?></p>        
        <form class="form-perso" method="POST" action="./ajouter_categorie.php">
            <div class="form-ligne">
                <label for="nom">à ajouter</label>                
                <input type="text" id="nom" name="nom">
            </div>
            <div class="form-ligne">
                <button type="reset" class="btn-normal" style="width:48%">annuler</button>
                <button type="submit" class="btn-imp" style="width:48%">ajouter</button>
            </div>
        </form>
        <form class="form-perso" method="POST" action="./supprimer_categorie.php">
            <div class="form-ligne"> 
                <label>à supprimer</label>          
                <?php
                    include "./include/select_categories.php";
                ?>
            </div>
            <div class="form-ligne">
                <button type="reset" class="btn-normal" style="width:48%">annuler</button>
                <button type="submit" class="btn-imp" style="width:48%">supprimer</button>
            </div>
        </form>
        <p class="succes"><?=$succesCategorie?></p>
    </fieldset>
    <fieldset style="width:40%">
        <legend>usagers</legend>
        <p class="erreur"><?=$erreurUsagers??''?></p>
        <form class="form-perso" method="POST" action="./supprimer_usager.php">
            <div class="form-ligne"> 
                <label>à supprimer</label> 
                <select name="usagers">
                <?php       
                    if($usagers[0]){                                
                        foreach($usagers[1] as $usager){
                            $id = $usager['id'];
                            $pseudo = $usager['pseudo'];
                            echo "
                                <option value='$id' name='id'>$pseudo</option>
                                ";
                        }
                    }else
                        ;
                ?>
                </select>         
            </div>
            <div class="form-ligne">
                <button type="reset" class="btn-normal" style="width:48%">annuler</button>
                <button type="submit" class="btn-imp" style="width:48%">supprimer</button>
            </div>
        </form>
        <p class="succes"><?=$succesUsagers??''?></p>
    </fieldset>
</main>