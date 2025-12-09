<?php 
    include_once "./include/head.php";
    include_once "./include/nav.php";
    include_once "./include/bd.php";

    $erreur = null;
    $succes = null;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $mdpActuel = trim($_POST['mdp_actuel']);
        $nouvMdp = trim($_POST["mdp_nouveau"]);
        $nouvMdpConf = trim($_POST["mdp_nouveau_conf"]);
        $idUsager = $_SESSION["id"];
        
        if($nouvMdp === $nouvMdpConf){
            $statut = changer_mdp($mdpActuel, $nouvMdp, $idUsager);
            if($statut[0]){
                $succes = $statut[1];
                header("Location: profil.php");
                exit;
            }
            else{
                $erreur = $statut[1];
            }
        }
        else{
            $erreur = "la confirmation du mot de passe et le nouveau mot de passe ne correspondent pas";
        }
    }
?>
    <main class="main-form">
        <h1>modifier le mot de passe</h1>
        <p class="succes"><?=$succes?></p>        
        <fieldset  class="fieldset">
            <form class="form-perso" method="post">
                <div class="form-ligne">
                    <label for="mdp_actuel">mot de passe actuel</label>
                    <input name="mdp_actuel" id="mdp_actuel" type="password"/>
                </div>
                <div class="form-ligne">
                    <label for="mdp_nouveau">nouveau mot de passe</label>
                    <input name="mdp_nouveau" id="mdp_nouveau" type="password"/>
                </div>
                <div class="form-ligne">
                    <label for="mdp_nouveau_conf">confirmation</label>
                    <input name="mdp_nouveau_conf" id="mdp_nouveau_conf" type="password"/>
                </div>                
                <button class="btn-imp" style="height:64px;" type="submit">
                    modifier le mot de passe
                </button>
            </form>            
        </fieldset>
        <p class="erreur"><?=$erreur??$_SESSION['message']??''?></p>
    </main>
<?php
    include "./include/footer.php"
?>