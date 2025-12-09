<?php include "./include/head.php"?>
    <div class="header-image"></div>
    <?php include "./include/nav.php";
        
        if(isset($_SESSION['email_confirme'])&&!$_SESSION['email_confirme']){
            include_once './include/message_demande_conf.php';
        }
    ?>
    <main>
        <h1>À propos</h1><br>
        <div>
            <p>Réalisé dans le cadre du cours de Développement d'applications Web 1.</p><br>
            <p>Au collège Lionel-Groulx à Sainte-Thérèse durant la session d'automne 2025.</p>
        </div>
        
    </main>
<?php include './include/footer.php'?>