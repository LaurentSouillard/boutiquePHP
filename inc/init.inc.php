<?php

// connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=php_boutique_doranco' ,  'root' , '' , [ PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING , PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'] );

//var_dump($pdo);

//ouverture de session
session_start();

//-----
// définition des constantes
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . '/boutique_php/' );
define("URL", 'http://localhost/boutique_php/');

//------------
// declaration de variable
$content = '';

// inclusion de fonciton 
require_once('fonction.inc.php');

