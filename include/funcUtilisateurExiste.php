<?php 
    function utilisateurExiste(string $fileStr, $pseudo, $mdp){  
        $file = fopen($fileStr, 'r');

        if ($file === false) {
            echo "<p class='erreur'>un problème est survenu au niveau de la base de donnée";
            return false;
        }
        
        while(($logins = fgetcsv($file, 0, '|')) !== false){
            if (!is_array($logins) || count($logins) < 2) {
                continue;
            }

            // nettoyer les champs
            $lignePseudo = trim($logins[0]);
            $ligneMdp    = trim($logins[1]);

            // comparaison simple (voir note sur le hashing plus bas)
            if ($lignePseudo === $pseudo && $ligneMdp === $mdp) {
                fclose($file);
                return true;
            }
        }
        fclose($file);        
        return false;
    }