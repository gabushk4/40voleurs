
<?php 
    include "./include/head.php";
    include "./include/nav.php";
?>
    </header>
    <main class="main-form">
        <div class="historique-vendre">
            <?php 
                const MIN_TITRE = 1;
                const MAX_TITRE = 50;
                const MIN_DESC = 10;
                const MAX_DESC = 500;
                const MIN_PRIX = 0;
                const MAX_PRIX = 1000000;
                const IMG_DEFAULT = './assets/brand.png';
                const MIN_PSEUDO = 2;
                const MAX_PSEUDO = 20;
                const URL_BASE = 'http://142.44.247.33/~usager41/quarante_voleurs/vendre.php';

                $message = '';
                $method = $_SERVER['REQUEST_METHOD'];

                if($method == "POST"){                    
                    $dateAjout = time();
                    $pseudo = $_SESSION['pseudo'];

                    @$fData = fopen('./data.csv', 'a');   
                    @$negociable = $_POST['negociable'] == 'on' ? 'oui' : 'non';    
                    @$valeursSet =  @isset(
                        $_POST['titre'],
                        $_POST['description'],
                        $_POST['prix'],
                        $pseudo)  && ($negociable == 'oui' || $negociable == 'non');   
                             
                    
                    @$img_url = IMG_DEFAULT;

                    if($fData && $valeursSet){                        
                        include "./include/funcValeurCorrecte.php";
                        include "./include/funcRemplirQueries.php";

                        if(isset($_FILES['couverture']) && $_FILES['couverture']['error'] === UPLOAD_ERR_OK && ($_FILES['couverture']['type'] != "image/jpeg" && 
                        $_FILES['couverture']['type'] != "image/png")){
                            $_SESSION['message'] ="format de l'image invalide; doit-être soit un .png ou .jpeg";    
                            header("Location: ".$URL_BASE.
                                RemplirQueries(
                                    ['description', $_POST['description']],
                                    ['prix', $_POST['prix']],
                                    ['negociable', $_POST['negociable']],
                                    ['titre', $_POST['titre']]
                                )
                            );
                            exit;
                        }
                        elseif(!ValeurCorrecte(strlen(str_replace(' ', '', $_POST['titre'])), MIN_TITRE, MAX_TITRE)){
                            $_SESSION['message'] = 'titre invalide; sa longueur doit être entre 1 et 50 caractères';
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['description', $_POST['description']],
                                    ['prix', $_POST['prix']],
                                    ['negociable', $_POST['negociable']]
                                )
                            );
                            exit;
                        }
                        elseif(!ValeurCorrecte(strlen(str_replace(' ', '', $_POST['description'])), MIN_DESC, MAX_DESC)){
                            $_SESSION['message'] = 'description invalide; sa longueur doit être entre 10 et 500 caractères';
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['titre', $_POST['titre']], 
                                    ['prix',$_POST['prix']],
                                    ['negociable',$_POST['negociable']]
                                )
                            );
                            exit;
                        }
                        elseif(!ValeurCorrecte($_POST['prix'], MIN_PRIX, MAX_PRIX)){
                            $_SESSION['message'] = "prix invalide; doit être entre 0 et 1'000'000";
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['titre', $_POST['titre']], 
                                    ['description',$_POST['description']],
                                    ['negociable',$_POST['negociable']]
                                )
                            );
                            exit;
                        }
                        elseif($negociable !== 'oui' && $negociable !== 'non'){
                            $_SESSION['message'] = 'negociable doit être inscrit';
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['titre', $_POST['titre']], 
                                    ['description',$_POST['description']],
                                    ['prix',$_POST['prix']]
                                )
                            ); 
                            exit;                       
                        }               
                        elseif($fData){
                            unset($_SESSION['message']);

                            $repertoire = './televersements/';
                            $img_url = $repertoire . $_FILES['couverture']['name'];

                            $moved = move_uploaded_file($_FILES['couverture']['tmp_name'], $img_url);

                            if(!$moved){
                                $message .= "l'image ne peut être téléversée; veuillez réessayer plus tard";
                            }

                            fwrite($fData, $_POST['titre'].'|'.$_POST['description'].'|'.$_POST['prix'].'|'.$negociable.'|'.$img_url.'|'.$pseudo.'|'.$dateAjout."\n");
                        
                            include "./include/funcAfficherAnnonce.php";
                        
                            afficherAnnonce([
                                $_POST['titre'],
                                $_POST['description'],
                                $_POST['prix'],
                                $negociable,
                                $img_url,
                                $pseudo,
                                $dateAjout
                            ]);
                            echo "
                                <div class='revenir-accueil'>
                                    <a href='./index.php' class='btn-imp'>revenir à l'accueil</a>
                                </div>";
                            
                        }
                    }
                    fclose($fData);                    
                }
                
            ?>
        </div>
        <h2>Vendre</h2>
        <h3 class="erreur"><?=
            $_SESSION['message']??''?></h3>
        <fieldset class="fieldset" title="vendre">
            <form class="form-perso" method="POST" enctype="multipart/form-data">
                <div class="form-ligne">
                    <label for="titre">titre</label>
                    <input id="titre" name="titre" value="<?= $_GET['titre'] ?? '' ?>"/>
                </div>    
                <div class="form-ligne">
                    <label for="description">description</label>
                    <textarea id="description" name="description"> <?= isset($_GET['description']) ? str_replace('+', ' ', $_GET['description']) :'' ?></textarea>
                </div>
                <div class="form-ligne">
                    <label for="prix">prix ($)</label>
                        <input id="prix" name="prix" type="number" placeholder="0 - 1'000'000" value="<?= $_GET['prix'] ?? '' ?>"/>
                </div>
                <div class="form-ligne">
                    <label for="negociable">négociable?</label>
                    <input type="checkbox" id="negociable" name="negociable" <?= (isset($_GET['negociable']) && $_GET['negociable'] === 'on') ? 'checked' : '' ?>/>
                </div>
                <div class="form-ligne">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                    image: <input name="couverture" size="35" type="file">
                </div>
                <div class="form-ligne" style="height:64px">
                    <button type="submit" class="btn-imp" style="width:100%; font-size: 24px;">
                    vendre
                    </button>
                </div>            
            </form>
        </fieldset>
    </main>
    <?php include "./include/footer.php"?>