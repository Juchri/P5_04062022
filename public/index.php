<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Core\Main;

// On définit une constante contenant le dossier racine du projet
define('ROOT', dirname(__DIR__));

// On importe l'autoloader
require_once ROOT.'/vendor/autoload.php';

// On instancie Main (notre routeur)
$app = new Main();

// On démarre l'application
$app->start();