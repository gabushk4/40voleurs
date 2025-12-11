<?php
    include_once "./include/bd.php";  
    session_start(); 

    $_SESSION['erreur_categories'] = "";
    $_SESSION['succes_categories'] = "";

    $method = $_SERVER['REQUEST_METHOD'];

    if($method == 'POST'){
        $idCategorie = $_POST['categorie'];

        if(isset($idCategorie)){
            $statut = supprimer_categorie($idCategorie);
            if($statut[0])
                $_SESSION['succes_categories'] = "catégorie supprimée avec succès";
            else
                $_SESSION['erreur_categories'] = $statut[1];
        }
        else{
            $_SESSION['erreur_categories'] = "impossible d'identifier la catégorie";
        }
    }

    header('Location: admin.php');
    exit;