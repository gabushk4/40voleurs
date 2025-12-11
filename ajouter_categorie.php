<?php
    include_once "./include/bd.php";  
    session_start(); 

    $_SESSION['erreur_categories'] = "";
    $_SESSION['succes_categories'] = "";

    $method = $_SERVER['REQUEST_METHOD'];

    if($method == 'POST'){
        $nomCategorie = $_POST['nom'];

        $categoriesExistantes = array_column(obtenir_categories(), "titre");
        echo var_dump($categoriesExistantes);
        if(isset($nomCategorie)){
            if(!in_array($nomCategorie, $categoriesExistantes)){
                $statut = ajouter_categorie($nomCategorie);
                if($statut[0])
                    $_SESSION['succes_categories'] = "catégorie $nom ajoutée avec succès";
                else
                    $_SESSION['erreur_categories'] = $statut[1];
            }
            else{
                $_SESSION['erreur_categories'] = "Le nom de la catégorie existe déjà";
            }
        }
        else{
            $_SESSION['erreur_categories'] = "nom de la categorie vide";
        }
    }

    header('Location: admin.php');
    exit;