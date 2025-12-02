<?php
    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    // crée une instance de PHPMailer et active les exceptions
    $mail = new PHPMailer(true);

    // paramètres du serveur
    $mail->isSMTP();     
    $mail->Host       = "in-v3.mailjet.com";
    $mail->Port       = 587;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // données de connexion fournies par Mailjet
    $mail->Username   = "..."; // votre clé API
    $mail->Password   = "..."; // votre clé secréte

    // adresse d'origine, l'existence du domaine sera vérifié par Mailjet (vous
    // pouvez utiliser ici votre adresse personnelle)
    $mail->setFrom('202259467@edu.clg.qc.ca', 'Gabriel Pereira');

    function envoyer_courriel($destinataire, $objet, $text){
        
    }