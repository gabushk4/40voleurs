<?php
    include "./include/bd.php";

    echo "<h2>Connexion à la base de données</h2>";

    $pdo = get_pdo();

    if (!$pdo) {
        echo "<p>Houston, we have a problem;";
    }

    /* echo "<h2>Ajout d'un article</h2>";

    $id_categorie = 1;
    $id_usager = 1;
    $titre = "Un titre";
    $description = "Une descriptnio";
    $prix = 100;
    $negociable = 0; // 0 ou 1, pas true ou false
    $chemin_image = null;
    $date_pub = date('Y-m-d H:i:s'); // date courante

    $succes = ajouter_article($id_categorie, $id_usager, $titre, $description,
        $prix, $negociable, $chemin_image, $date_pub);
    
    if ($succes) {
        echo "Article ajouté";
    } else {
        echo "Une erreur s'est produite";
    } */

    echo "<h2>Les articles</h2>";

    $res = obtenir_articles();

    if($res){
        foreach ($res as $article) {
            echo $article['titre'] ."<br>";
            echo $article['prix'] . " $<hr>";            
        }
    }else
        echo "Une erreur s'est produite";
