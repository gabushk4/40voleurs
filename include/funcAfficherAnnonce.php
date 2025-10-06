<?php 
define("TITRE_I",0);
    define("DESCRIPTION_I", 1);
    define("PRIX_I",2);
    define("NEGOCIABLE_I",3);
    define("IMAGE_I",4);
    define("AUTEUR_I",5);
function afficherAnnonce($annonce, $separateur = ',') {
    
    if(is_array($annonce)){
        $annonce = array_map('strip_tags', $annonce);
        $negociable = $annonce[NEGOCIABLE_I] == "oui" ? "Négociable" : "Non négociable";
        echo '<div class="annonce">
                <a href="'.$annonce[IMAGE_I].'" target="_blank">
                    <img src="'.$annonce[IMAGE_I].'" alt="'.$annonce[TITRE_I].'"/>
                </a>
                <div class="annonce-texte-conteneur">
                    <div>
                        <h2>'.$annonce[TITRE_I].'</h2>
                        <h3>'.$annonce[DESCRIPTION_I].'</h3>
                    </div>
                    <div class="annonce-soustexte-conteneur">
                        <p>'.$annonce[PRIX_I].'$</p>
                        <p>'.$negociable.'</p>
                        <p class="annonce-auteur">'.$annonce[AUTEUR_I].'</p>
                    </div>
                </div>
            </div>';
    }else{
        echo <<<EOF
            <div class="annonce">
                <img src=""/>
                <h2>Annonce non chargée</h2>
                <p>erreur</p>
                <p>erreur</p>
                <p>erreur</p>
                <p>erreur</p>
            </div>
        EOF;
    }
};