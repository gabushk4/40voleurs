<?php 
    include "./include/head.php";
    include "./include/nav.php";

    $erreur = '';
    $succes = '';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];
        

        $fLogins = fopen("./logins.csv", 'r');
        if($fLogins && isset($pseudo) && isset($mdp)){
            while(!feof($fLogins)){
                $logins = fgetcsv($fLogins, 0, '|');
                if($logins[0] == $pseudo && $logins[1] == $mdp){
                    $_SESSION['connecteA40V'] = true;
                    $_SESSION['pseudo'] = $pseudo;
                    fclose($fLogins);
                    header("Location: index.php");
                    exit;
                }                
            }
            if(!isset($_SESSION['connecteA40V'])){
                $erreur = 'vos informations ne correspondent pas';
            }
        }
        else{
            $erreur="impossible de se connecter, veuillez réessayer plus tard";
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
                <button type="submit">se connecter</button>
            </form>            
        </fieldset>
        <p class="erreur"><?=$erreur?></p>
    </main>