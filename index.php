<?php include "./include/head.php"?>
    <div class="header-image"></div>
    <?php include "./include/nav.php";
        
        
        if(isset($_SESSION['email_confirme'])&&!$_SESSION['email_confirme']){
            include_once './include/message_demande_conf.php';
        }

        $method = $_SERVER['REQUEST_METHOD'];    
        if($method != "POST"){
            $erreur = '';
            $recherche = '';
            $date = '';
            $prixMin = 0;
            $prixMax = 2000000;
            $idCategorie = -1;
            $offset=0;
        }
        
        if($method == "POST"){        
            $idCategorie = $_POST['categorie']??-1;            
            $recherche = $_POST['recherche']??'';
            
            if(isset($_POST['min'], $_POST['max'])){
                $min = $_POST['min'];
                $max = $_POST['max'];
                if($min < $max){
                    $prixMin = $min;
                    $prixMax = $max;
                }else{
                    $prixMax = $max;
                    $erreur = "le prix minimum doit être plus petit que le maximum";
                }
            }
            if(isset($_POST['date'])){
                $date = $_POST['date'];
                $date = "$date 00:00:00";                
            }
            if(isset($_POST["offset"])){
                $offset = $_POST["offset"];
            }
        }
        include_once './include/bd.php';
        $categories = obtenir_categories();
    ?>
    
    <div class="recherche">
        <fieldset class="fieldset-recherche">
        <legend>recherche</legend>
            <form class="barre-rech" role="search" method="POST">
                <input type="search" name="recherche" placeholder="rechercher" aria-label="recherche" value="<?=$recherche??''?>">
                <button class="btn-normal" type="submit">
                    <img src="./assets/rechercher.png" width="32" height="32" alt="loupe">
                </button>
                <input type="hidden" name="categorie" value="<?=$idCategorie?>">
                <input type="hidden" name="min" value="<?=$prixMin?>">
                <input type="hidden" name="max" value="<?=$prixMax?>">
                <input type="hidden" name="date" value="<?=substr($date,0,10)?>">
            </form>
            <form method="POST">
                <input type="hidden" name="recherche" value="<?=$recherche?>">
                <input type="hidden" name="min" value="<?=$prixMin?>">
                <input type="hidden" name="max" value="<?=$prixMax?>">
                <input type="hidden" name="date" value="<?=substr($date,0,10)?>">

            <select class="dropdown-button" name="categorie" onchange="this.form.submit()">
                <option value="-1">toutes</option>
                <?php
                    
                    if(isset($categories)){                                
                        foreach($categories as $row){
                            $selectionne = $row['id'] == $idCategorie;
                            $value = $row['id'];
                            $titre = $row['titre'];
                            echo "<option value='$value' ".($selectionne?'selected':'').">$titre</option>";
                        }
                    }else
                        echo "<option value='6'>autres</option>";
                ?>
            </select> 
            </form> 
            <fieldset class="fieldset-recherche">
                <legend>prix</legend>
            <form class="form-horizontal" method="POST">
                <input type="hidden" name="recherche" value="<?=$recherche?>">
                <input type="hidden" name="categorie" value="<?=$idCategorie?>">
                <input type="hidden" name="date" value="<?=substr($date,0,10)?>">

                <div>
                    <div class="form-ligne">
                        <label>minimum</label>
                        <input type="number" name="min" min="0" max="2000000" value="<?=$prixMin?>" onfocus="this.select()">                    
                    </div>
                    <div class="form-ligne">
                        <label>maximum</label>    
                        <input type="number" name="max" min="0" max="2000000" value="<?=$prixMax?>" onfocus="this.select()">                    
                    </div>
                </div>
                <button class="btn-normal" style="width:80px" type="submit">appliquer</button>
            </form>   
            </fieldset>
            <fieldset class="fieldset-recherche">
                <input type="hidden" name="recherche" value="<?=$recherche?>">
                <input type="hidden" name="categorie" value="<?=$idCategorie?>">
                <input type="hidden" name="min" value="<?=$prixMin?>">
                <input type="hidden" name="max" value="<?=$prixMax?>">

                <legend>date de publication</legend>
                <form class="form-horizontal" method="POST">
                        <div class="form-ligne">
                            <label>à partir de</label>
                            <input type="date" name="date">
                        </div>
                    <button class="btn-normal" style="width:80px" type="submit">appliquer</button>
                </form>
            </fieldset>         
            </fieldset>
    </div>
    <p class="erreur"><?=$erreur??''?></p>  
    <main class="vitrine">  
            
        <?php            
            include_once './include/funcAfficherAnnonce.php';
            include_once './include/bd.php';
            // lire toutes les lignes dans un tableau
            try{
                $articles = obtenir_articles($idCategorie, $offset, $recherche, $date, $prixMin, $prixMax);
                if(isset($articles)){
                    foreach ($articles as $article){
                        afficherAnnonce($article, afficherSupprimer:$estAdmin);            
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
    <div class="pagination-conteneur">
        <form method="POST">
            <div class="pagination">
            <?php $nbArticles = obtenir_nb_articles($idCategorie, 0, $recherche, $date, $prixMin, $prixMax); 
                $limiteParPage = 16;
                $nbPages = ceil($nbArticles['nb_articles']/$limiteParPage);
                for($i = 0; $i<$nbPages; $i++){
                    $nb = $i+1;
                    echo "
                    <div>
                        <input type='hidden' name='offset' value='$i'>
                        <button class='btn-normal' style='width:32px;height:32px' type='submit'>$nb</button>
                    </div>
                    ";
                }
            ?>
            </div>
            <input type="hidden" name="recherche" value="<?=$recherche?>">
            <input type="hidden" name="categorie" value="<?=$idCategorie?>">
            <input type="hidden" name="min" value="<?=$prixMin?>">
            <input type="hidden" name="max" value="<?=$prixMax?>">
            <input type="hidden" name="date" value="<?=substr($date,0,10)?>">

        </form>
    </div>
<?php include './include/footer.php'?>