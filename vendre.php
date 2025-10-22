
<?php 
    include "./include/head.php";
    include "./include/nav.php";
?>
    </header>
    <main class="main-vendre">
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

                $method = $_SERVER['REQUEST_METHOD'];
                

                if($method == "POST"){
                    $message = '';
                    $erreurDebut = 'impossible de continuer la demande, ';
                    $erreurComplement = 'veuillez réessayer';
                    $dateAjout = time();

                    @$fData = fopen('./data.csv', 'a');       
                    @$valeursSet =  @isset(
                        $_POST['titre'],
                        $_POST['description'],
                        $_POST['prix'],
                        $_POST['vendeur']);            
                    @$negociable = $_POST['negociable'] == 'on' ? 'oui' : 'non';
                    @$img_url = IMG_DEFAULT;

                    if($fData && $valeursSet && ($negociable == 'oui' || $negociable == 'non')){                        
                        include "./include/funcValeurCorrecte.php";
                        include "./include/funcRemplirQueries.php";

                        if(isset($_POST['image_url']))
                            $img_url = $_POST['image_url'];

                        if(!ValeurCorrecte(strlen(str_replace(' ', '', $_POST['titre'])), MIN_TITRE, MAX_TITRE)){
                            $message .= 'titre invalide; sa longueur doit être entre 1 et 50 caractères';
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['message', $message],
                                    ['description',$_POST['description']],
                                    ['prix',$_POST['prix']],
                                    ['negociable',$_POST['negociable']],
                                    ['image_url',$_POST['image_url']],
                                    ['vendeur',$_POST['vendeur']]
                                )
                            );
                        }
                        elseif(!ValeurCorrecte(strlen(str_replace(' ', '', $_POST['description'])), MIN_DESC, MAX_DESC)){
                            $message .= 'description invalide; sa longueur doit être entre 10 et 500 caractères';
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['message', $message],
                                    ['titre', $_POST['titre']], 
                                    ['prix',$_POST['prix']],
                                    ['negociable',$_POST['negociable']],
                                    ['image_url',$_POST['image_url']],
                                    ['vendeur',$_POST['vendeur']]));
                        }
                        elseif(!ValeurCorrecte($_POST['prix'], MIN_PRIX, MAX_PRIX)){
                            $message .= "prix invalide; doit être entre 0 et 1'000'000";
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['message', $message],
                                    ['titre', $_POST['titre']], 
                                    ['description',$_POST['description']],
                                    ['negociable',$_POST['negociable']],
                                    ['image_url',$_POST['image_url']],
                                    ['vendeur',$_POST['vendeur']]
                                )
                            );
                        }
                        elseif($negociable !== 'oui' && $negociable !== 'non'){
                            $message .= 'negociable doit être inscrit';
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['message', $message],
                                    ['titre', $_POST['titre']], 
                                    ['description',$_POST['description']],
                                    ['prix',$_POST['prix']],                                    
                                    ['image_url',$_POST['image_url']],
                                    ['vendeur',$_POST['vendeur']]
                                )
                            );                        
                        }
                        elseif(!ValeurCorrecte(strlen($_POST['vendeur']), MIN_PSEUDO, MAX_PSEUDO)){
                            $message .= 'nom du vendeur invalide; sa longueur doit être entre 2 et 20 caractères';
                            header('Location: '.$URL_BASE.
                                RemplirQueries(
                                    ['message', $message],
                                    ['titre', $_POST['titre']], 
                                    ['description',$_POST['description']],
                                    ['prix',$_POST['prix']],
                                    ['negociable',$_POST['negociable']],
                                    ['image_url',$_POST['image_url']]
                                )
                            );
                        }                        
                        elseif($fData){
                            $erreurDebut = '';
                            $message = '';
                            fwrite($fData, $_POST['titre'].'|'.$_POST['description'].'|'.$_POST['prix'].'|'.$negociable.'|'.$img_url.'|'.$_POST['vendeur'].'|'.$dateAjout."\n");
                        
                            include "./include/funcAfficherAnnonce.php";
                        
                            afficherAnnonce([
                                $_POST['titre'],
                                $_POST['description'],
                                $_POST['prix'],
                                $negociable,
                                $img_url,
                                $_POST['vendeur'],
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
        <h2 class="erreur"><?=
            $_GET['message']??''?></h2>
        <h1>Vendre</h1>
        <form class="form-vendre" method="POST">
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
                <label for="image_url">image (url)</label>
                <input type="url" id="image_url" name="image_url" value="<?= $_GET['image_url'] ?? '' ?>"/>
            </div>
            <div class="form-ligne">
                <label for="vendeur">vendeur</label>
                <input id="vendeur" name="vendeur" value="<?= $_GET['vendeur'] ?? '' ?>"/>
            </div>
            <div class="form-ligne" style="height:64px">
                <button type="submit" class="btn-imp" style="width:100%; font-size: 24px;">
                vendre
                </button>
            </div>            
        </form>
    </main>
    <?php include "./include/footer.php"?>