<form class="demande-conf" action="envoyer_courriel_conf.php" method="POST">
    <p>Tu dois confirmer ton courriel</p>
    <div style="width:200px;height:32px">
        <button class="btn-normal">cliques ici pour confirmer</button>
    </div>
   <?php echo $_SESSION['email_confirme'];?>
</form>