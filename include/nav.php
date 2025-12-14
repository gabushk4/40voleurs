<?php
    $connecte = false;
    $estAdmin = false;
    if(session_status() != PHP_SESSION_ACTIVE)
        session_start();

    if(isset($_SESSION['connecteA40V'])){
        $connecte = true;
    }

    if(isset($_SESSION['est_admin'])){
        $estAdmin = $_SESSION['est_admin'];
    }
?>

<nav class="nav-custom">
    <div class="nav-I">
        <a href="index.php" class="brand">
            <img src="./assets/brand.png" class="" alt="raton-laveur">
            <p>Les 40 voleurs</p>
        </a>
        
    </div>
    <a id="hamburger">☰</a>     
    <ul class="nav-menu">        
        <li>
            <?php if($connecte)
                echo "<a href='./vendre.php'>vendre</a>";
            ?>
        </li>            
        <li>
            <a href="./a_propos.php">à propos</a>
        </li>
    <?php if($estAdmin):?>
        <li>    
            <a href="./admin.php">administration</a>            
        </li>
    <?php endif; ?>        
    </ul>  
    <div id="theme">
        <button id="theme-toggle" class="btn-normal">Changer de thème</button>
    </div> 
    <?php if(!$connecte): ?>
        <div id='compte-btns'>
            <a class='btn-normal' href='connexion.php'>connexion</a>
            <a class='btn-imp' href='inscription.php'>inscription</a>  
        </div> 
            
    <?php elseif (isset($_SESSION['pseudo'])): 
        $pseudo = $_SESSION['pseudo'];
    ?>    
        <div class='nav-I'>                
            <p class='connecte'>bienvenue <?=$pseudo?> <?=$estAdmin?"(admin)":"" ?></p>
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
    <?php endif; ?>      
</nav>

</header>