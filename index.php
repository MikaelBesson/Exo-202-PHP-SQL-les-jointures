<?php

/**
 * 1. Commencez par importer le script SQL disponible dans le dossier SQL.
 * 2. Connectez vous à la base de données blog.
 */

try {
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'exo_202';

    $conn = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

/**
 * 3. Sans utiliser les alias, effectuez une jointure de type INNER JOIN de manière à récupérer :
 *   - Les articles :
 *     * id
 *     * titre
 *     * contenu
 *     * le nom de la catégorie ( pas l'id, le nom en provenance de la table Categorie ).
 *
 * A l'aide d'une boucle, affichez chaque ligne du tableau de résultat.
 */
// TODO Votre code ici.

    $search = $conn->prepare("
        SELECT Article.id, Article.title, Article.content, categorie.name
        FROM article
            INNER JOIN categorie ON article.category_fk = categorie.id
");
    $search->execute();
        echo "<pre>";
    print_r($search->fetchAll());
        echo "</pre>";

    /**
 * 4. Réalisez la même chose que le point 3 en utilisant un maximum d'alias.
 */
// TODO Votre code ici.

    $search = $conn->prepare("
        SELECT ar.id, ar.title, ar.content, cat.name
        FROM article as ar
            INNER JOIN categorie as cat ON ar.category_fk = cat.id
");
    $search->execute();
    echo "<pre>";
    print_r($search->fetchAll());
    echo "</pre>";

/**
 * 5. Ajoutez un utilisateur dans la table utilisateur.
 *    Ajoutez des commentaires et liez un utilisateur au commentaire.
 *    Avec un LEFT JOIN, affichez tous les commentaires et liez le nom et le prénom de l'utilisateur ayant écris le comentaire.
 */

// TODO Votre code ici.
//ajout d'un utilisateur
    $firstName = 'Dark';
    $lastName = 'Vador';
    $mail = 'imyourfather@etoilenoire.com';
    $password = 55666;

    $insert = $conn->prepare("
        INSERT INTO utilisateur (firstName, lastName, mail, password) 
        VALUES (:firstName,:lastName,:mail,:password)
    ");
    $insert->bindValue(':firstName', $firstName);
    $insert->bindValue(':lastName', $lastName);
    $insert->bindValue(':mail', $mail);
    $insert->bindValue(':password', $password);
    $insert->execute();

//ajout d'un commentaire
    $id = $conn->lastInsertId();
    $newCom = $conn->prepare("
        INSERT INTO commentaire (content, user_fk, article_fk)
        VALUES ('rejoint le coté obscur', $id,2 )
    ");
    $newCom->execute();

    $request = $conn->prepare("
         SELECT com.content, com.user_fk
        FROM commentaire as com
            INNER JOIN utilisateur ON user_fk = utilisateur.id
    ");

    $result = $request->execute();
    echo $result;





} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}