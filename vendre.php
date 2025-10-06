
<?php include "./include/head.php";
    $historique = [];
?>
<?php include "./include/nav.php"?>
    </header>
    <main class="main-vendre">
        <div class="historique-vendre">
            <?php 
                const MIN_TITRE = 1;
                const MAX_TITRE = 50;
                const MIN_DESC = 10;
                const MAX_DESC = 500;
                const 
                $method = $_SERVER['REQUEST_METHOD'];

                if($method == "POST"){
                    @$fData = fopen('./data.csv', 'a');                    
                    @$negociable = $_POST['negociable'] == 'on' ? 'oui' : 'non';
                    if($fData && 
                        @isset($_POST['titre'],
                            $_POST['description'],
                            $_POST['prix'],
                            $_POST['negociable'],
                            $_POST['image_url'],
                            $_POST['vendeur'])
                    ){
                        fwrite($fData, $_POST['titre'].','.$_POST['description'].','.$_POST['prix'].','.$negociable.','.$_POST['image_url'].','.$_POST['vendeur'].'\n');
                        include "./include/funcAfficherAnnonce.php";
                        
                        afficherAnnonce([
                            $_POST['titre'],
                            $_POST['description'],
                            $_POST['prix'],
                            $negociable,
                            $_POST['image_url'],
                            $_POST['vendeur']
                        ]);
                    }
                    else{
                        echo "<h2 class='erreur'>impossible de continuer la demande, veuillez réessayer</h2>";
                    }
                    fclose($fData);                    
                }
                
            ?>
        </div>
        <h1>Vendre</h1>
        <form class="form-vendre" method="POST">
            <div class="form-ligne">
                <label for="titre">titre</label>
                <input id="titre" name="titre"/>
            </div>    
            <div class="form-ligne">
                <label for="description">description</label>
                <textarea id="description" name="description"></textarea>
            </div>
            <div class="form-ligne">
                <label for="prix">prix ($)</label>
                    <input id="prix" name="prix" type="number" placeholder="0 - 1'000'000"/>
            </div>
            <div class="form-ligne">
                <label for="negociable">négociable?</label>
                <input type="checkbox" id="negociable" name="negociable"/>
            </div>
            <div class="form-ligne">
                <label for="image_url">image (url)</label>
                <input type="url" id="image_url" name="image_url"/>
            </div>
            <div class="form-ligne">
                <label for="vendeur">vendeur</label>
                <input id="vendeur" name="vendeur"/>
            </div>
            <div class="form-ligne" style="height:64px">
                <button type="submit" class="btn-imp" style="width:100%; font-size: 24px;">
                vendre
                </button>
            </div>
            
        </form>
    </main>
    <?php include "./include/footer.php"?>