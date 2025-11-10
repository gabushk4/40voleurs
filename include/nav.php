<?php
    $connecte = false;
    session_start();

    if(isset($_SESSION['connecteA40V'])){
        $connecte = true;
    }
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
        <li class="dropdown">
            <a class="dropdown-button" onclick="toggleDropdown()">catégories ▼</a>
            <ul class="dropdown-content" id="menuDropdown">                    
                <li><a href="#">meubles</a></li>
                <li><a href="#">appareils électroniques</a></li>
                <li><a href="#">vêtements</a></li>
            </ul>
        </li>
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
            <form action='deconnexion.php'>
                <div class='nav-I'>
                    <p class='connecte'>bienvenu $pseudo</p>
                    <button class='btn-normal' type='submit'>
                        <img 
                            src='./assets/deconnexion.png' width='32' height='32' alt='deconnexion'
                        />
                    </button>
                <div>
            </form>
            ";
        }
    ?>
            
</nav>