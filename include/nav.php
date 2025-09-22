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
        <a id="hamburger">☰</a>   
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
</nav>