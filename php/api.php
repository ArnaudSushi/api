<?php

require_once "./config.php";

function get_list_articles($pdo)
{ //je passe en paramètre mon objet PDO précédemment créé afin d'exécuter ma requête

    $sql = "SELECT * FROM articles";
    $exe = $pdo->query($sql); //création de la requête Sql pour aller chercher tous les articles
    $liste_article = array(); //création d'un tableau qui va contenir tous nos articles

    while ($result = $exe->fetch(PDO::FETCH_OBJ)) { //Exécution de la requête définie plus haut

        array_push($liste_article, array("ID" => $result->ID, "Titre" => $result->Titre, "Date" => $result->Date)); //on ajoute tous les articles dans notre tableau
    }
    return $liste_article; //on renvoie le tableau contenant tous nos articles
}

function get_article_by_id($id, $pdo)
{ //je passe en paramètre de ma fonction l'id de l'article souhaité et l'objet PDO pour exécuter la requête

    $sql = "SELECT * FROM articles WHERE ID = " . $id; //je réalise ma requête avec l'ID passée en paramètres
    $exe = $pdo->query($sql); //j'exécute ma requête

    while ($result = $exe->fetch(PDO::FETCH_OBJ)) {

        $detail_article = array("Titre" => $result->Titre, "Date" => $result->Date, "Article" => $result->Article); //je mets le résultat de ma requête dans une variable

    }
    return $detail_article; //je retourne l'article en question
}

$possible_url = array("get_list_articles", "get_articles"); //je définis les URLs valables
$value = "Une erreur est survenue"; //je mets le message d'erreur par défaut dans une variable

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url)) { //si l'URL est OK

    switch ($_GET["action"]) {

        case "get_list_articles":
            $value = get_list_articles($pdo);
            break; //Je récupère la liste des articles

        case "get_articles":
            if (isset($_GET["id"])) $value = get_article_by_id($_GET["id"], $pdo); //si l'ID est spécifié alors je renvoie l'article en question

            else $value = "Argument manquant";
            break;
    } //si l'ID n'est pas valable je change mon message d'erreur
}
exit(json_encode($value)); //je retourne ma réponse en JSON
