<?php 
    include_once "./include/head.php";
    include_once "./include/nav.php";
    include_once "./include/bd.php";

    $erreur = '';
    $succes = '';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        $pseudo = trim($_POST['pseudo']);
        $mdp = trim($_POST['mdp']);  
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $courriel = trim($_POST['courriel']);
        $id_usager = ajouter_usager($pseudo, $mdp, $nom, $prenom, $courriel);
        if(isset($id_usager)){        
            $succes = 'inscription réussie';
            $_SESSION['connecteA40V'] = true;
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id'] = $id_usager;
            header("Location: index.php");
            exit;
        }else{
            $erreur="impossible de s'inscrire, veuillez réessayer plus tard";
        } 
    }
?>
    <main class="main-form">
        <h1>inscription</h1>
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
                <div class="form-ligne">
                    <label for="prenom">prenom</label>
                    <input name="prenom" id="prenom" type="text"/>
                </div>
                <div class="form-ligne">
                    <label for="nom">nom</label>
                    <input name="nom" id="nom" type="text"/>
                </div>
                <div class="form-ligne">
                    <label for="courriel">courriel</label>
                    <input name="courriel" id="courriel" type="email"/>
                </div>
                <button class="btn-imp"  style="align-self: flex-end;height:32px; width: 100%;" type="submit">s'inscrire</button>
            </form>            
        </fieldset>
        <p class="erreur"><?=$erreur?></p>
    </main>
<?php
    include "./include/footer.php"
?>