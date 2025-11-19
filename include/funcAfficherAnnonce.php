<?php 
define("TITRE_I",0);
define("DESCRIPTION_I", 1);
define("PRIX_I",2);
define("NEGOCIABLE_I",3);
define("IMAGE_I",4);
define("AUTEUR_I",5);
define('DATE_AJOUT', 6);
function afficherAnnonce($annonce) {    
    if(is_array($annonce)){
        $annonce = array_map('strip_tags', $annonce);
        $negociable = $annonce[NEGOCIABLE_I] == "oui" ? "négociable" : "non négociable";
        $image = strlen($annonce[IMAGE_I])>1?$annonce[IMAGE_I]:'./assets/brand.png';
        $date = date('d-m-Y', $annonce[DATE_AJOUT]);
        $prix = $annonce[PRIX_I] == 0 ? 'gratuit' : "$annonce[2]$";
        echo '<div class="annonce">
                <a href="'.$annonce[IMAGE_I].'" target="_blank">
                    <img src="http://142.44.247.33/~usager41/quarante_voleurs'.$image.'" alt="'.$image.'"/>
                </a>
                <div class="annonce-texte-conteneur">
                    <div>
                        <h2>'.$annonce[TITRE_I].'</h2>
                        <h3>'.$annonce[DESCRIPTION_I].'</h3>
                    </div>
                    <div class="annonce-soustexte-conteneur">
                        <p>'.$prix.'</p>
                        <p>'.$negociable.'</p>
                        <p class="annonce-auteur">'.$annonce[AUTEUR_I].'</p>
                        <p>'.$date.'</p>
                    </div>
                </div>
            </div>';
    }
};