<?php
    include_once "./include/bd.php";  
    session_start(); 

    $_SESSION['erreur_usagers'] = "";
    $_SESSION['succes_usagers'] = "";

    $method = $_SERVER['REQUEST_METHOD'];

    if($method == 'POST'){
        $idUsager = $_POST['usagers'];

        if(isset($idUsager)){
            $statut = supprimer_usager($idUsager);
            if($statut[0])
                $_SESSION['succes_usagers'] = $statut[1];
            else
                $_SESSION['erreur_usagers'] = $statut[1];
        }
        else{
            $_SESSION['erreur_usagers'] = "impossible d'identifier l'usager";
        }
    }

    header('Location: admin.php');
    exit;