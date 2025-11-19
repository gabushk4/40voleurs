<?php
    //mkdir("./televersements", 0755);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        echo "<h2>Détails</h2>";
        $nom    = $_FILES['fichier']['name'];
        $taille = $_FILES['fichier']['size'];
        $temp   = $_FILES['fichier']['tmp_name'];
        $type   = $_FILES['fichier']['type'];
        $erreur = $_FILES['fichier']['error'];

        echo "<pre>";
        echo "Nom d'origine          : $nom\n";
        echo "Taille                 : $taille octets\n";
        echo "Emplacement temporaire : $temp\n";
        echo "Type MIME              : $type\n";
        echo "Code d'erreur          : $erreur\n";
        echo "</pre>";
        // s'il s'agit d'un fichier d'une image JPEG ou PNG
        if ( $_FILES['fichier']['type'] == "image/jpeg"
            || $_FILES['fichier']['type'] == "image/png") {

            // répertoire où l'application conserve les fichiers téléversés
            $repertoire = './televersements/';

            // nouveau chemin du fichier à conserver
            $chemin = $repertoire . $_FILES['fichier']['name'];

            // on déplace le fichier
            if ( move_uploaded_file($_FILES['fichier']['tmp_name'], $chemin) ) {
                // affichage de l'image
                echo '<img src="' . $chemin . '" alt="Une image" style="max-width: 640px; ' .
                'max-height: 480px;">';
            } else {
                "<p>Le fichier ne peut être déplacé</p>'";
            }
        } else {
            echo "<p>L'image ne peut être affichée</p>'";
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        Fichier : <input name="fichier" size="35" type="file">
        <input type="submit" value="Envoyer le fichier">
    </form>
</body>
</html>