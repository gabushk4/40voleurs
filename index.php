<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./style.css?v=1.0" rel="stylesheet">
        <link rel="icon" type="image/png" href="./assets/brand.png">
        <script defer src="./script.js"></script>
        <title>Les quarante voleurs</title>        
        
    </head>
    <body>
        <header>
            <div class="header-image"></div>
            <nav class="nav-custom">
                <div class="nav-I">
                        <a href="index.php">
                            <img src="./assets/brand.png" class="" href="./index.php">
                        </a>
                    <form class="barre-rech" role="search">
                        <input class="" type="search" placeholder="rechercher" aria-label="recherche"/>
                        <button class="btn-normal" type="submit">
                            <img src="./assets/rechercher.png" width="32" height="32" alt="loupe">
                        </button>
                    </form>
                </div>
                <ul class="nav-menu">
                    <li>
                        <a aria-current="page" href="#">vendre</a>
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
                <div id="compte-btns">
                    <button class="btn-normal">connexion</button>
                    <div class="separateur"/>
                    <button class="btn-imp">inscription</button>
                </div> 
                <a id="hamburger">☰</a>            
            </nav>
        </header>
        <main>

        </main>
    </body>
</html>