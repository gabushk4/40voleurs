<?php 
    include_once "./include/head.php";
    include_once "./include/nav.php";
    include_once "./include/bd.php";
    include_once "./include/courriel.php";
    include_once "./include/funcValeurCorrecte.php";

    $erreur = '';
    $succes = '';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $valide = true;
        $mdp = trim($_POST['mdp']);
        $mdp_conf = trim($_POST['mdp_conf']);
        $pseudo = trim($_POST['pseudo']);
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $courriel = trim($_POST['courriel']);

        if($mdp != $mdp_conf){
            $erreur = 'les mots de passes ne correspondent pas';
            $valide = false;
        }
        else if(!ValeurCorrecte(strlen($mdp), 12, 54)){
            $len = strlen($mdp);
            $erreur = "le mot de passe doit être entre 12 et 54 caractères: $len";
            $valide = false;
        }       
        else if(!ValeurCorrecte(strlen($pseudo), 2, 25)){
            $erreur = "le pseudo doit être entre 2 et 25 caractères";
            $valide = false;
            $pseudo = '';
        }        
        else if(!ValeurCorrecte(strlen($nom), 2, 50)){
            $erreur = "le nom doit être entre 2 et 50 caractères";
            $valide = false;
            $nom = '';
        }        
        else if(!ValeurCorrecte(strlen($prenom), 2, 50)){
            $erreur = "le prénom doit être entre 2 et 50 caractères";
            $valide = false;
            $prenom = '';
        }        
        else if(!ValeurCorrecte(strlen($courriel), 6, 254)){
            $erreur = "l'adresse courriel doit être entre 6 et 254 caractères";
            $valide = false;
            $courriel = '';
        }

        if($valide){            
            $id_usager = ajouter_usager($pseudo, $mdp, $nom, $prenom, $courriel);
            if(isset($id_usager)){        
                $succes = 'inscription réussie';
                $_SESSION['connecteA40V'] = true;
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $id_usager;
                $_SESSION['email_confirme'] = false;
                envoyer_courriel_confirmation($courriel, $id_usager);
                header("Location: index.php");
                exit;
            }else{
                $erreur="impossible de s'inscrire, veuillez réessayer plus tard";
            } 
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
                    <input name="pseudo" id="pseudo" value="<?=$pseudo??''?>"/>
                </div>
                <div class="form-ligne">
                    <label for="mdp">mot de passe</label>
                    <input name="mdp" id="mdp" type="password"/>
                </div>
                <div class="form-ligne">
                    <label for="mdp_conf">confirmation</label>
                    <input name="mdp_conf" id="mdp_conf" type="password"/>
                </div>
                <div class="form-ligne">
                    <label for="prenom">prenom</label>
                    <input name="prenom" id="prenom" type="text" value="<?=$prenom??''?>"/>
                </div>
                <div class="form-ligne">
                    <label for="nom">nom</label>
                    <input name="nom" id="nom" type="text" value="<?=$nom??''?>"/>
                </div>
                <div class="form-ligne">
                    <label for="courriel">courriel</label>
                    <input name="courriel" id="courriel" type="email" value="<?=$courriel??''?>"/>
                </div>
                <button class="btn-imp"  style="align-self: flex-end;height:32px; width: 100%;" type="submit">s'inscrire</button>
            </form>            
        </fieldset>
        <p class="erreur"><?=$erreur?></p>
    </main>
<?php
    include "./include/footer.php"
?>