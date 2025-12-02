<?php
include_once './include/head.php';
include_once './include/nav.php';
include_once './include/courriel.php';

$method = $_SERVER['REQUEST_METHOD'];
$succes = '';
$erreur = '';

if($method == 'POST'){
    $courriel = $_SESSION['courriel'];
    $idUsager = $_SESSION['id'];
    if(isset($courriel)){
        $envoye = envoyer_courriel_confirmation($courriel, $idUsager);
        if($envoye)
            $succes = "courriel envoyé à $courriel (regarde tes spams)";
        else{
            $erreur = "problème a l'envoie; réessayes";
        }
    }
    else{
        $_SESSION['message'] = "reconnectes-toi pour confirmer ton courriel";
        $erreur = 'reconnectes-toi pour confirmer ton courriel';
        header('Location:connexion.php');
        exit;
    }
}?>
<main>
    <h3 class="succes"><?=$succes?></h3>
    <h3 class="erreur"><?=$erreur??$_SESSION['message']?></h3>
</main>
<?php include_once './include/footer.php';?>
