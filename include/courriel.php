<?php
    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    include_once 'bd.php';

    function get_mail(){
         // crée une instance de PHPMailer et active les exceptions
        $mail = new PHPMailer(true);

        // paramètres du serveur
        $mail->isSMTP();     
        $mail->Host       = "in-v3.mailjet.com";
        $mail->Port       = 587;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // données de connexion fournies par Mailjet
        $mail->Username   = "9e7a2e8ca43e615686b7d521ec9f98c5"; // votre clé API
        $mail->Password   = "118ba788b428166cedd7e44642a196eb"; // votre clé secréte

        // adresse d'origine, l'existence du domaine sera vérifié par Mailjet (vous
        // pouvez utiliser ici votre adresse personnelle)
        $mail->setFrom('202259467@edu.clg.qc.ca', 'Gabriel Pereira');

        return $mail;
    }
   
    function envoyer_courriel_confirmation($courrielDestinataire, $idDestinataire){
        try{
            $mail = get_mail();
            // adresse de destination
            $mail->addAddress($courrielDestinataire, obtenir_pseudo($idDestinataire));
            
            $lien = "http://142.44.247.33/~usager41/quarante_voleurs/confirmation.php?id_usager=$idDestinataire";
            $emailHtml = <<<HTML
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8" />
                    <title>Confirmation de votre courriel</title>
                </head>
                <body style="margin:0; padding:0; background:#f5f5f5; font-family:Arial, sans-serif;">

                    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5; padding:30px 0;">
                        <tr>
                            <td align="center">

                                <table width="480" cellpadding="20" cellspacing="0" style="background:white; border-radius:8px; text-align:left;">
                                    <tr>
                                        <td>

                                            <h2 style="margin-top:0; color:#333;">Confirmez votre courriel</h2>

                                            <p style="font-size:15px; color:#555;">
                                                Merci de vous être inscrit !  
                                                Pour activer votre compte, cliquez sur le bouton ci-dessous.
                                            </p>

                                            <p style="text-align:center; margin:30px 0;">
                                                <a href=$lien 
                                                style="display:inline-block; background:#007bff; color:white; padding:12px 24px; 
                                                        text-decoration:none; font-size:16px; border-radius:6px;">
                                                    Confirmer mon courriel
                                                </a>
                                            </p>

                                            <p style="font-size:13px; color:#777;">
                                                Si le bouton ne fonctionne pas, utilisez ce lien :<br>
                                                <a href=$lien style="color:#007bff;">
                                                    $lien
                                                </a>
                                            </p>

                                            <p style="font-size:12px; color:#999; margin-top:30px;">
                                                — L’équipe
                                            </p>

                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>

                </body>
                </html>
                HTML;
            $emailText = "Confirmes ton courriel

                Merci de t'être inscrit !

                Pour activer ton compte, cliques sur le lien ci-dessous ou copies-le dans votre navigateur :

                $lien

                Si tu n’as pas créé de compte, tu peux ignorer cet email.

                — L’équipe
                ";

            // contenu
            $mail->IsHTML(true);
            $mail->Subject    = "Confirmation de compte";
            $mail->Body       = $emailHtml;
            $mail->AltBody    = $emailText;

            // envoi du message
            $mail->send();
            return true;
        } catch (Exception $e) {
            $_SESSION['message'] = "Échec de l'envoi du message. Erreur : {$mail->ErrorInfo}";
            return false;
        }
    }