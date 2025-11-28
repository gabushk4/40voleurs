<?php 
include_once 'bd.php';
function afficherAnnonce($annonce, $afficherPseudo=true) {    
    if(is_array($annonce)){
        $negociable = $annonce["negociable"] == 1 ? "négociable" : "non négociable";
        $image = './assets/brand.png';
        if(isset($annonce["chemin_image"]))
            $image = "http://142.44.247.33/~usager41/quarante_voleurs$annonce[chemin_image]";
        $prix = $annonce["prix"] == 0 ? 'gratuit' : "$annonce[prix]$";
        $timestamp = strtotime($annonce["date_pub"]);
        $date = date("j M Y", $timestamp);
        echo "
            <div class='annonce'>
        ";
        if(!$afficherPseudo){
            echo "
            <form >
                <button class='btn-supprimer'>
                    <img
                        src='./assets/croix.png'
                    />
                </button>
            </form>
            ";
        }
        echo "
                <a href='$image' target='_blank'>
                    <img src='$image' alt='".$annonce["chemin_image"]."'/>
                </a>
                <div class='annonce-texte-conteneur'>
                    <div>
                        <h2>".$annonce["titre"]."</h2>
                        <h3>".$annonce["description"]."</h3>
                    </div>
                    <div class='annonce-soustexte-conteneur'>
                        <p>$prix</p>
                        <p>$negociable</p>
        ";
        if ($afficherPseudo) {
            echo "
                        <p class='annonce-auteur'>".obtenir_pseudo($annonce['id_usager'])."</p>
            ";
        }
        echo "
                        <p>$date</p>
                    </div>
                </div>
            </div>";
    }
};