<?php 
    include "./include/head.php";
    include "./include/nav.php";
    include "./include/funcUtilisateurExiste.php";

    $erreur = '';
    $succes = '';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $pseudo = $_POST['pseudo'];
        $mdp = $_POST['mdp'];        
        
        if(utilisateurExiste(fileStr: "./logins.csv", pseudo: $pseudo, mdp: $mdp)){    
            $_SESSION['connecteA40V'] = true;
            $_SESSION['pseudo'] = $pseudo;
            header("Location: index.php");
            exit;             
        }else{
            $erreur = 'vos informations ne correspondent pas';
        }
    }
?>
    </header>
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