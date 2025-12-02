<?php 
    include_once "./include/head.php";
    include_once "./include/nav.php";
    include_once "./include/bd.php";

    $erreur = '';
    $succes = '';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $pseudo = trim($_POST['pseudo']);
        $mdp = trim($_POST['mdp']);        

        $usager = connecter_usager(pseudo: $pseudo, mdp: $mdp);
        
        if(count($usager) > 0){    
            $_SESSION['connecteA40V'] = true;
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id'] = $usager['id'];
            $_SESSION['email_confirme'] = $usager['email_confirme'];
            header("Location: index.php");
            exit;             
        }else{
            $erreur = 'vos informations ne correspondent pas';
        }
    }
?>
    <main class="main-form">
        <h1>connexion</h1>
        <p class="succes"><?=$succes?></p>        
        <fieldset  class="fieldset">
            <form class="form-perso" method="post">
                <div class="form-ligne">
                    <label for="pseudo">pseudonyme</label>
                    <input name="pseudo" id="pseudo"/>
                </div>
                <div class="form-ligne">
                    <label for="mdp">mot de passe</label>
                    <input name="mdp" id="mdp" type="password"/>
                </div>
                <button class="btn-imp" style="align-self: flex-end" type="submit">se connecter</button>
            </form>            
        </fieldset>
        <p class="erreur"><?=$erreur?></p>
    </main>
<?php
    include "./include/footer.php"
?>