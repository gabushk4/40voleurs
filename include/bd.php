<?php
function get_pdo(){
    $host    = '127.0.0.1'; // 127.0.0.1 si la BD et l'application sont sur le même serveur
    $db      = 'usager41'; // nom de la base de données
    $user    = 'usager41';
    $pass    = '%Gabou2005php%';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

// ----------------------------------------------------------------------------
// Ajoute un article. Retourne true ou false pour indiquer le succès ou l'échec
// de l'opération.
// ----------------------------------------------------------------------------
function ajouter_article($categorie, $usager, $titre, $description, $prix,
    $negociable, $chemin, $date) {

    $retour = true;

    $sql = "INSERT INTO article (id_categorie, id_usager, titre,
        description, prix, negociable, chemin_image, date_pub)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    try {
        $pdo = get_pdo();
        $stmt= $pdo->prepare($sql);
        $stmt->execute([$categorie, $usager, $titre, $description, $prix,
            $negociable, $chemin, $date]);
    } catch (Exception $e) {
        echo $e->getMessage();
        //exit;
        $retour =  false;
    }

    return $retour;
}
// ----------------------------------------------------------------------------
// Retourne une liste d'articles. Retourne false pour indiquer l'échec
// de l'opération.
// ----------------------------------------------------------------------------
function obtenir_articles():mixed{
    $sql = "SELECT * FROM article ORDER BY date_pub DESC";

    try{
        $pdo = get_pdo();        
        $stmt = $pdo->query($sql);   
        return $stmt;
    }catch(Exception $e){
        echo "une erreur est survenue $e";
        return null;
    }
}
function obtenir_articles_usager($idUsager):mixed{
    $sql = "SELECT * FROM article WHERE id_usager = ? ORDER BY date_pub DESC";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUsager]);
        return $stmt;
    }catch(Exception $e){
        echo "une erreur est survenue $e";
        return null;
    }
}
// ----------------------------------------------------------------------------
// Ajoute un usager. Retourne true ou false pour indiquer le succès ou l'échec
// de l'opération.
// ----------------------------------------------------------------------------
function ajouter_usager($pseudo, $mdp, $nom, $prenom, $courriel){
    $sql = "INSERT INTO usager (pseudo, mdp, nom, prenom, courriel) VALUES (?, ?, ?, ?, ?)";

    try{
        $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt -> execute([$pseudo, $hash_mdp, $nom, $prenom, $courriel]);
        return $pdo->lastInsertId();
    }catch(Exception $e){
        $retour = null;
    }
}
// ----------------------------------------------------------------------------
// Vérifie les informations d'un usager à la connexion. Retourne true ou false 
// pour indiquer le succès ou l'échec de l'opération.
// ----------------------------------------------------------------------------
function connecter_usager($pseudo, $mdp): mixed{
    $sql = "SELECT mdp, id FROM usager WHERE pseudo = ?";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pseudo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            
            $hash = $row['mdp'];

            $id_usager = $row['id'];

            if(!isset($hash, $id_usager) || !password_verify($mdp, $hash)){
                return null;
            }
            
            return $id_usager;
        }else{
            return null;
        }
    }catch(Exception $e){
        echo "erreur de connexion $e";
        return null;
    }
}

function obtenir_pseudo($id_usager){
    $sql = "SELECT pseudo FROM usager WHERE id = ?";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_usager]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row)
            $pseudo = $row['pseudo'];
        else return null;

        if(!isset($pseudo))
            return null;

        return $pseudo;
    }catch(Exception $e){

        return null;
    }
}

