<?php
    $connecte = false;
    session_start();

    if(isset($_SESSION['connecteA40V'])){
        $connecte = true;
    }
    $method = $_SERVER['REQUEST_METHOD'];
    
    $idCategorie = -1;
    if($method == "POST"){        
        $idCategorie = $_POST['categorie']; 
    }
    include_once 'bd.php';
?>

<nav class="nav-custom">
    <div class="nav-I">
        <a href="index.php" class="brand">
            <img src="./assets/brand.png" class="" href="./index.php" alt="raton-laveur">
            <p>Les 40 voleurs</p>
        </a>
        <form class="barre-rech" role="search">
            <input class="" type="search" placeholder="rechercher" aria-label="recherche"/>
            <button class="btn-normal" type="submit">
                <img src="./assets/rechercher.png" width="32" height="32" alt="loupe">
            </button>
        </form>
    </div>
    <ul class="nav-menu">
        <a id="hamburger">☰</a>   
        <li>
            <?php if($connecte)
                echo "<a href='./vendre.php'>vendre</a>";
            ?>
        </li>
        <form method="POST">
            <select class="dropdown-button" name="categorie" onchange="this.form.submit()">
                <option value="-1">toutes</option>
                <?php
                    $stmt = obtenir_categories();
                    if(isset($stmt)){                                
                        foreach($stmt as $row){
                            $selectionne = $row['id'] == $idCategorie;
                            echo "<option value='".$row['id']."' ".($selectionne?'selected':'').">".$row['titre']."</option>";
                        }
                    }else
                        echo "<option value='6'>autres</option>";
                ?>
            </select>
        </form>
        <li>
            <a href="#">à propos</a>
        </li>
    </ul>  
    <div id="theme">
        <button id="theme-toggle" class="btn-normal">Changer de thème</button>
    </div> 

    <?php
        if(!$connecte){
            echo "<div id='compte-btns'>
                    <a class='btn-normal' href='connexion.php'>connexion</a>
                    <a class='btn-imp' href='inscription.php'>inscription</a>  
                <div> 
            ";
        }else if (isset($_SESSION['pseudo'])){
            $pseudo = $_SESSION['pseudo'];
            echo "
            <div class='nav-I'>                
                <p class='connecte'>bienvenue $pseudo</p>
                <form action='profil.php'>
                <button type='submit' class='btn-normal'>
                    <img
                        src='./assets/profile.png' width='32' height='32' alt='photo_profil'
                    />
                </button>
                </form>
                <form action='deconnexion.php'>
                    <button class='btn-normal' type='submit'>
                        <img 
                            src='./assets/deconnexion.png' width='32' height='32' alt='deconnexion'
                        />
                    </button>
                
                </form>
            <div>
            ";
        }
    ?>
            
</nav>

</header>