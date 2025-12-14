<?php
    $recherche = $recherche??'';
    $idCategorie = $idCategorie??'';
    $prixMin = $prixMin??'';
    $prixMax = $prixMax??'';
    $date = $date??'';
?>
<div class="pagination-conteneur">
        <form method="POST">
            <div class="pagination">
            <?php                 
                $limiteParPage = $limitePagination??16;
                $nbPages = ceil($nbArticles/$limiteParPage);
                $derniereAffichee = -1;
                if($nbPages>1)
                    for($i = 0; $i<$nbPages; $i++){
                        $pageVisible =
                            $i == 0 ||
                            $i == $nbPages - 1 ||
                            $i == $offset ||
                            $i == $offset - 1 ||
                            $i == $offset + 1;                    
                                        
                        if($pageVisible):
                            $nb = $i+1;
                            if($i > $derniereAffichee + 1){
                                echo "
                                    <div>
                                        <p>...</p>
                                    </div>
                                ";
                            }
            ?>                                        
                            <div>
                                <button class='btn-normal' name='offset' value="<?=$i?>" style='width:32px;height:32px' type='submit'><?=$nb?></button>
                            </div>                                                            
                        <?php 
                            $derniereAffichee = $i;
                            endif;                
                    }   ?>
            </div>
            <input type="hidden" name="recherche" value="<?=$recherche??''?>">
            <input type="hidden" name="categorie" value="<?=$idCategorie??''?>">
            <input type="hidden" name="min" value="<?=$prixMin??''?>">
            <input type="hidden" name="max" value="<?=$prixMax??''?>">
            <input type="hidden" name="date" value="<?=substr($date??'',0,10)?>">

        </form>
    </div>