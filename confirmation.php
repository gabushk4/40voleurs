<?php

include_once './include/head.php';
include_once './include/nav.php';
include_once './include/bd.php';

$method = $_SERVER['REQUEST_METHOD'];

if($method == 'GET'){
    $idUsager = $_GET['id_usager'];
    $confirme = confirmer_courriel($idUsager);
    if(isset($confirme)){
        $_SESSION['email_confirme'] = true;
        header('Location:index.php');
        exit;
    }
}?>

<?php if(!$confirme):?>
    <main>
        <p class="erreur">Ça n'a pas fonctionné...<?=$_SESSION['message']?></p>
        <br>
        <form action="envoyer_courriel_conf.php" method="POST">
            <button class="btn-imp" type="submit">Renvoyer un email de confirmation</button>
        </form>
    </main>
<?php endif?>
