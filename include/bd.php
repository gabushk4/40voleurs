<?php
function get_pdo(){
    $host    = '127.0.0.1'; // 127.0.0.1 si la BD et l'application sont sur le même serveur
    $db      = 'usager41'; // nom de la base de données
    $user    = 'usager41';
    $pass    = 'CBrXcez885LL';
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
        //echo $e->getMessage();
        //exit;
        $retour =  false;
    }

    return $retour;
}

function obtenir_articles():bool|PDOStatement{
    $sql = "SELECT * FROM article";

    try{
        $pdo = get_pdo();        
        $stmt = $pdo->query($sql);        
        return $stmt;
    }catch(Exception $e){
        return false;
    }
}
