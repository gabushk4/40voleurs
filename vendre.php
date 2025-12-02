
<?php 
    include "./include/head.php";
    include "./include/nav.php";
    include_once './include/bd.php';

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
    $emailConfirme = $_SESSION['email_confirme'];
?>
   <?php if($emailConfirme): ?>
    <main class="main-form">
        <div class="historique-vendre">
            <?php   
                $method = $_SERVER['REQUEST_METHOD'];
                
                $categories = []; 
                if($method == "GET"){
                    //$_SESSION['message'] = " ";
                }
                if($method == "POST"){                                       
                    $dateAjout = date("Y-m-d H:i:s", time());
                    $pseudo = $_SESSION['pseudo'];
                    $id_usager = $_SESSION['id'];

                    @$negociable = $_POST['negociable'] == 'on' ? 1 : 0;    
                    @$valeursSet =  @isset(
                        $_POST['titre'],
                        $_POST['description'],
                        $_POST['prix'],
                        $pseudo)  && ($negociable == 1 || $negociable == 0);   
                             
                    
                    @$img_url = IMG_DEFAULT;

                    if($valeursSet){                       
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
                        elseif($negociable !== 1 && $negociable !== 0){
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
                        else{
                            
                            $repertoire = '/televersements';
                            $tmp_img = $_FILES['couverture']['tmp_name'];

                            $LARGEUR = 344;

                            $img = false;
                            $typeImage = $_FILES['couverture']['type'];

                            switch($typeImage)
                            {
                                case 'image/jpeg':
                                    $img = imagecreatefromjpeg($tmp_img);
                                    break;
                                case 'image/png':
                                    $img = imagecreatefrompng($tmp_img);
                                    break;
                                default:
                                    $_SESSION['message'] = "le type de l'image doit être soit png ou jpeg; type reçu: $typeImage";
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

                            if(!$img){
                                $_SESSION['message'] = "il fut impossible de traiter l'image; veuillez réessayer avec soit un png ou un jpeg";
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

                            $img = imagescale($img, $LARGEUR);

                            if(!$img){
                                $_SESSION['message'] = 'une erreur inattendue sest passée au traitement de limage. Veuillez ressayer';
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

                            $img_name = $_FILES['couverture']['name'];
                            $img_url = "$repertoire/$img_name";
                            $file = __DIR__ . $img_url;

                            switch($typeImage)
                            {
                                case 'image/jpeg':
                                    
                                    $img = imagejpeg($img, $file);
                                    break;
                                case 'image/png':
                                    $img = imagepng($img, $file);
                                    break;
                                default:
                                    $_SESSION['message'] = "le type de l'image doit être soit png ou jpeg; type reçu: $typeImage";
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

                            if(!$img){
                                $_SESSION['message'] = "impossible de sauvegarder l'image dans nos serveurs; veuillez réessayer";
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

                            
                            ajouter_article(1, $id_usager, trim($_POST['titre']), trim($_POST['description']), $_POST['prix'], $negociable, $img_url, $dateAjout);

                            include_once "./include/funcAfficherAnnonce.php";
                        
                            afficherAnnonce([
                                "titre"=>$_POST['titre'],
                                "description"=>$_POST['description'],
                                "prix"=>$_POST['prix'],
                                "negociable"=>$negociable,
                                "chemin_image"=>$img_url,
                                "date_pub"=>$dateAjout,
                                "id_usager"=>$id_usager
                            ]);
                            echo "
                                <div class='revenir-accueil'>
                                    <a href='./index.php' class='btn-imp'>revenir à l'accueil</a>
                                </div>
                            ";        
                            $_SESSION['message']="";                    
                        }
                    }                  
                }                
            ?>
        </div>
        <h2>Vendre</h2>
        <h3 class="erreur"><?=
            $_SESSION['message']??''?>
        </h3>
        
        <fieldset class="fieldset" title="vendre">
            <form class="form-perso" method="POST" enctype="multipart/form-data">
                <div class="form-ligne">
                    <label for="titre">titre</label>
                    <input id="titre" name="titre" value="<?=$_GET['titre'] ?? '' ?>"/>
                </div>    
                <div class="form-ligne">
                    <label for="description">description</label>
                    <textarea id="description" name="description"><?=isset($_GET['description'])?str_replace('+', ' ', $_GET['description']):'' ?></textarea>
                </div>
                <div class="form-ligne">
                    <label for="categories">categories</label>
                    <select name="categories" id="categories">
                        <option value="0">toutes</option>
                        <?php
                            $stmt = obtenir_categories();
                            if(isset($stmt)){                                
                                foreach($stmt as $row){
                                    echo "<option value='".$row['id']."' >".$row['titre']."</option>";
                                }
                            }else
                                echo "<option value='6'>divers</option>";
                        ?>
                    </select>
                </div>
                <div class="form-ligne">
                    <label for="prix">prix ($)</label>
                    <input id="prix" name="prix" type="number" placeholder="0 - 1'000'000" value="<?=$_GET['prix']??''?>"/>
                </div>
                <div class="form-ligne">
                    <label for="negociable">négociable?</label>
                    <input type="checkbox" id="negociable" name="negociable" <?=(isset($_GET['negociable']) && $_GET['negociable'] === 'on') ? 'checked' : '' ?>/>
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
    <?php else:?>
        <main>
        <form class="demande-conf" action="">
            <p>Tu dois confirmer ton courriel pour vendre de quoi</p>
            <div style="width:200px;height:32px">
                <button class="btn-normal" href="">cliques ici pour confirmer</button>
            </div>        
        </form>
        </main>
    <?php endif ?>
    <?php include "./include/footer.php"?>