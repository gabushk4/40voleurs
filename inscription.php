<?php 
    include "./include/head.php";
    include "./include/nav.php";

    $erreur = '';
    $succes = '';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        session_start();
        $pseudo = trim($_POST['pseudo']);
        $mdp = trim($_POST['mdp']);        

        $fLogins = fopen("./logins.csv", 'a');
        if($fLogins && isset($pseudo) && isset($mdp)){
            fwrite($fLogins, "$pseudo|$mdp\n");
            $succes = 'inscription réussie';
            $_SESSION['connecteA40V'] = true;
            $_SESSION['pseudo'] = $pseudo;
            $connecte = true;
            fclose($fLogins);
        }
        else{
            $erreur="impossible de s'inscrire, veuillez réessayer plus tard";
        }
    }
?>
    </header>
    <main class="main-form">
        <p class="succes"><?=$succes?></p>
        <fieldset title="inscription" class="fieldset">
            <form class="form-perso" method="post">
                <div class="form-ligne">
                    <label for="pseudo">pseudonyme</label>
                    <input name="pseudo" id="pseudo"/>
                </div>
                <div class="form-ligne">
                    <label for="mdp">mot de passe</label>
                    <input name="mdp" id="mdp" type="password"/>
                </div>
                <button type="submit">s'inscrire</button>
            </form>            
        </fieldset>
        <p class="erreur"><?=$erreur?></p>
    </main>