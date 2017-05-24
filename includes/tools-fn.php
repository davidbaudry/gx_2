<?php

function isAdmin()
{
    if ($_SESSION['user_is_admin'] == true)
    {
        return true;
    }
    return false;        
}

function logAdmin($login, $pwd)
{
    global $database;
 
    //$login = Securite::bdd($login);
    //$password = Securite::bdd($pwd);
       
    // retrouver le user avec mot de passe et login
    $q = 'SELECT id'
            . ' FROM user'
            . ' WHERE login     = "'.$login.'" '
            . ' AND pwd         = "'.$pwd.'" '
            . ' LIMIT 1;';
    //echo $q;

    $res = $database    ->get_row($q, true);
    
    //print_r($res->id);
    //die();
    if ($res->id > 0)
    {
        $_SESSION['user_is_admin'] = true;
        return true;
    }
    return false;
}

function SqlToTime($Date, $Format = 'd/m/Y') {
    if (!$Date || $Date == '0000-00-00 00:00:00')
        return false;

    $DateArray = explode(' ', $Date);

    $parts = explode('-', $DateArray[0]);
    $Y = isset($parts[0]) ? $parts[0] : 0;
    $M = isset($parts[1]) ? $parts[1] : 0;
    $D = isset($parts[2]) ? $parts[2] : 0;

    $H = $m = $s = 0;
    if (isset($DateArray[1])) {
        $parts = explode(':', $DateArray[1]);
        $H = isset($parts[0]) ? $parts[0] : 0;
        $m = isset($parts[1]) ? $parts[1] : 0;
        $s = isset($parts[2]) ? $parts[2] : 0;
    }
    
    if ($Format == 'jour')
    {
        $jour = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi");
        return strtolower($jour[date("w", mktime((int) $H, (int) $m, (int) $s, (int) $M, (int) $D, (int) $Y))]) . ' ' . date("d/m/Y", mktime((int) $H, (int) $m, (int) $s, (int) $M, (int) $D, (int) $Y));
    }
    return date($Format, mktime((int) $H, (int) $m, (int) $s, (int) $M, (int) $D, (int) $Y));
    
    

    
}