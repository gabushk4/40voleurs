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

/**
Ajoute un article. Retourne true ou false pour indiquer le succès ou l'échec
de l'opération.
*/
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
/**
Retourne une liste d'articles. Retourne false pour indiquer l'échec
de l'opération.
*/
function obtenir_articles($categorie = -1, $offset = 0):mixed{
    $limit = 10;
    $offset *= $limit;

    if($categorie < 0)
        $sql = "SELECT * FROM article ORDER BY date_pub DESC LIMIT $limit OFFSET $offset";
    else
        $sql = $sql = "SELECT * FROM article WHERE id_categorie = $categorie ORDER BY date_pub DESC LIMIT $limit OFFSET $offset";

    try{
        $pdo = get_pdo();        
        $stmt = $pdo->query($sql);   
        return $stmt;
    }catch(Exception $e){
        echo "une erreur est survenue $e";
        return null;
    }
}
/**
 * Obtiens les articles d'un usager
 * @param int $idUsager 
 * @return array|null Retourne le stmt  si ca a marché
 */
function obtenir_articles_usager($idUsager):mixed{
    $sql = "SELECT * FROM article WHERE id_usager = ? ORDER BY date_pub DESC";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idUsager]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo "une erreur est survenue $e";
        return null;
    }
}
/**
 * Permet de supprimer un article 
 * @param mixed $idArticle
 * @return bool true si ca a marché
 */
function supprimer_article($idArticle):bool{
    $sql = "DELETE FROM article WHERE id = ?";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idArticle]);
        return true;
    }catch(Exception $e){
        echo "une erreur est survenue $e";
        return false;
    }
}
/** 
Ajoute un usager. Retourne true ou false pour indiquer le succès ou l'échec
de l'opération.
*/
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
/**
Vérifie les informations d'un usager à la connexion. Retourne l'usager ou null 
pour indiquer le succès ou l'échec de l'opération.
*/
function connecter_usager($pseudo, $mdp): mixed{
    $sql = "SELECT mdp, id FROM usager WHERE pseudo = ?";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pseudo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){            
            $hash = $row['mdp'];

            $usager = $row;

            if(!isset($hash) || !password_verify($mdp, $hash)){
                return null;
            }
            
            return $usager;
        }else{
            return null;
        }
    }catch(Exception $e){
        echo "erreur de connexion $e";
        return null;
    }
}
/**
 * Obtient le pseudo d'un usager avec son id
 * @param int $id_usager
 * @return string|null retourne null si loperation echoue
 */
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
        echo "erreur de connexion $e";
        return null;
    }
}
/**
 * obtient toutes les catégories 
 * @return PDOStatement|null Retourne null si l'operation echoue
 */
function obtenir_categories(){
    $sql = "SELECT * FROM categorie";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->query($sql);
        echo var_dump($stmt);
        return $stmt;
    }catch(Exception $e){
        echo "erreur de connexion $e";
        exit;
        
    }
}

function obtenir_titre_categorie($idCategorie){
    $sql = "SELECT titre FROM categorie WHERE id = ?";

    try{
        $pdo = get_pdo();
        $stmt = $pdo->query($sql);
        echo var_dump($stmt);
        return $stmt;
    }catch(Exception $e){
        echo "erreur de connexion $e";
        exit;
        
    }
}

