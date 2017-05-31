<?php
session_start();

// lecture des variables d'environnement
include_once '../includes/local_enviro.php';
include_once '../includes/traits/miscelleanous.php';

// composer
require '../vendor/autoload.php';
// spl autoloader
spl_autoload_register('chargerClasse');

// définition des raccourcis de chemins
define('INC', SITEROOT . 'includes/');
define('CSSROOT', LINK_BASE_URL . 'static/css/');
define('JSROOT', LINK_BASE_URL . 'static/js/');
// nom du site
define('SITENAME', 'BoardGame Scorer [2]');


// todo : déplacer cette fonction
function chargerClasse($classe)
{
    require 'classes/' . $classe . '.php'; // On inclut la classe correspondante au paramètre passé.
}


// todo : à virer
include_once INC . 'tools-fn.php';
include_once INC . 'games-fn.php';
include_once INC . 'display-fn.php';