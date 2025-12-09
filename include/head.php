<?php
    include_once 'include/bd.php';
    session_start();

    $method = $_SERVER['REQUEST_METHOD'];

    if($method == 'POST'){
        if(isset($_POST['idArticle'])){
            $idArticle = $_POST['idArticle'];
            if(!supprimer_article($idArticle)){
                $_SESSION['message']="impossible de supprimer l'article; veuilleuz réessayer plus tard";                
            }
            else{
                $_SESSION['message'] = "impossible de trouver l'article; informations manquantes ou invalides";
            }
        }
    }
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script>            
            const match = document.cookie.match(/(^| )theme=([^;]+)/);
            let theme = match ? match[2] : 'clair';
            document.documentElement.setAttribute('data-theme', theme);
        </script>
        <script src="./script.js" defer></script>
        <link href="./style.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="./assets/brand.png">
        <title>Les quarante voleurs</title>        
        
    </head>
    <body>
        <header>