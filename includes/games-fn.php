<?php

// ** GAME FUNCTION ** //
function gamesList()
{
    global $database;
       
    $q = '
        SELECT g.id, g.name AS gamename, g.is_extension, a.firstname, a.lastname, e.name AS editorname
        FROM games g
        INNER JOIN authors a ON(a.id = g.author_id)
        INNER JOIN editors e ON(e.id = g.editor_id)
        ORDER BY g.name ASC;';
    
    $games = $database->get_results($q, true);
    return $games;
}


function insertGame($data) {
    //print_r($data);
    global $database;
    
    $q = 'INSERT INTO `games` '
            . '(`id`, `name`, `is_extension`, `author_id`, `editor_id`, `description`, `is_collaborative`, `has_invert_score`) '
            . 'VALUES '
            . '(NULL, '
        . '"' . ($data['name']) . '",
            "' . ($data['is_extension']) . '", 
            "' . ($data['author_id']) . '",
            "' . ($data['editor_id']) . '",
            "' . ($data['is_collaborative']) . '",
            "' . ($data['has_invert_score']) . '",
            "' . ($data['description']) . '");';
    //echo $q;
    return $database->query($q);
}

function insertPlayer($data) {
    //print_r($data);
    global $database;
    
    $q = 'INSERT INTO `players` '
            . '(`id`, `firstname`, `lastname`) '
            . 'VALUES '
            . '(NULL, '
        . '"' . ($data['firstname']) . '",
            "' . ($data['lastname']) . '");';
    //echo $q;
    return $database->query($q);
}

// ** AUTHOR FUNCTION ** //
function authorList()
{
    global $database;
 
    $q = '
        SELECT id, firstname, lastname
        FROM authors
        ORDER BY lastname ASC;';
    
    $authors = $database->get_results($q, true);
    return $authors;
}

// ** EDITOR FUNCTION ** //
function editorList()
{
    global $database;
 
    $q = '
        SELECT id, name
        FROM editors
        ORDER BY name ASC;';
    
    $editors = $database->get_results($q, true);
    return $editors;
}

// ** PLAYERS FUNCTION ** //
function playersList()
{
    global $database;
 
    $q = '
        SELECT id, firstname, lastname, mainplayer
        FROM players
        ORDER BY mainplayer DESC, firstname ASC;';
    
    $players = $database->get_results($q, true);
    return $players;
}

function getPlayerFromId($player_id)
{
    global $database;
 
    $q = '
        SELECT id, firstname, lastname
        FROM players
        WHERE id = ' . ($player_id) . ';';
    
    $players = $database->get_row($q, true);
    return $players;
}

function getNbPlayedGamesByPlayer($player_id)
{
    global $database;
 
    $q = '
        SELECT g.name, g.id, COUNT(gpl.id) C
        FROM `gameplay_lines` gpl
        INNER JOIN gameplay gp ON(gp.id = gpl.gameplay_id)
        INNER JOIN games g ON(g.id = gp.game_id)
        WHERE `player_id` = ' . ($player_id) . '
        GROUP BY g.id
        ORDER BY C DESC
        LIMIT 1000';
    
    $players = $database->get_results($q, true);
    return $players;
}

// EN COURS
function getInfoGamePlayer($game_id, $player_id)
{
    global $database;
    
    //1. retouve les infos du jeu (surtout pour la notion de score inverse)
    $game_info = getGameFromId($game_id);
    $a_score_inverse = $game_info->has_invert_score;
    
    //2. retrouve les parties jouées pour ce jeu
    $gameplays = getGameplaysListFromGameid($game_id);
    $top_score = 0;
    $nb_gameplay = 0;
    
    //3. déroule les parties et regarde à chaque fois si le joueur a le meilleur score
    foreach ($gameplays as $gameplay)
    {
        $nb_gameplay++;
        // recherche le meilleur score
        $sens_du_tri = 'DESC';
        if ($a_score_inverse)
        { 
            $sens_du_tri = 'ASC';
        }
        $q_meilleur_score = '
            SELECT player_id FROM `gameplay_lines` 
            WHERE `gameplay_id` = ' . ($gameplay->id) . ' 
            ORDER BY `score` DESC 
            LIMIT 1';
        $meilleur_score = $database->get_row($q_meilleur_score, true);
        //var_dump($meilleur_score);
        $top_score += ($meilleur_score ->player_id == $player_id);
    }
    //var_dump($top_score);
    // préparation de la stat :
    $stat = $top_score .' partie(s) gagnée(s) - ';
    //var_dump($top_score.' '.$nb_gameplay);
    $stat .= round(($top_score/$nb_gameplay) * 100) . '%';   

    return $stat;
    
}

// ** GAMEPLAY FUNCTION ** //

function getGameplayFromId($gameplay_id)
{
    global $database;
    $q = '
            SELECT gp.id, gp.date, gm.name, p.firstname, p.lastname, gpl.score
            FROM gameplay gp 
            INNER JOIN gameplay_lines gpl ON (gpl.gameplay_id = gp.id)
            INNER JOIN games gm ON (gm.id = gp.game_id)
            INNER JOIN players p ON (p.id = gpl.player_id)
            WHERE gp.id = ' . ($gameplay_id) . '
            ORDER BY gpl.score DESC;
        ';
    
    $gameplay = $database->get_results($q, true);
    return $gameplay;
}

// retrouve les parties jouées pour un jeu
function getGameplaysListFromGameid($game_id)
{
    global $database;
    $q = '
            SELECT gp.id, gp.date
            FROM gameplay gp 
            WHERE gp.game_id = ' . ($game_id) . '
            ORDER BY gp.date ASC;
        ';
    
    $gameplays = $database->get_results($q, true);
    return $gameplays;
}

// retouve les participants d'un jeu
function getPlayersFromGameplayId($gameplay_id)
{
    global $database;
    $q = '
            SELECT p.firstname, p.lastname, gpl.score
            FROM gameplay_lines gpl
            INNER JOIN players p ON (p.id = gpl.player_id)
            WHERE gpl.gameplay_id = ' . ($gameplay_id) . '
            ORDER BY score ASC';
    $playersFromGameplayId = $database->get_results($q, true);
    return $playersFromGameplayId;       
    
}

function insertGameplay($data)
{
    global $database;

    $q = 'INSERT INTO `gameplay` (`id`, `date`, `game_id`) VALUES (NULL,  
        "' . ($data['date']) . '", 
        "' . ($data['game_id']) . '");';
    //echo $q;
    return $database->query($q);

}

function insertGameplayLine($gameplay_id, $player_id, $score)
{
    global $database;

    if(!$player_id)
    {
        return false;
    }

    $q = 'INSERT INTO `gameplay_lines` (`id`, `gameplay_id`, `player_id`, `score`) 
        VALUES (NULL, 
        "' . ($gameplay_id) . '", 
        "' . ($player_id) . '", 
        "' . ($score) . '"
        );';
    //echo $q;
    return $database->query($q);

}

function getPreviousGameplays($nb = 10)
{
    
    if ((!$nb) || ($nb < 0) || ($nb > 100))
    {
        $nb = 10;
    }
    global $database;
    $q = '
            SELECT gp.id, gp.date, gm.name, gp.game_id,
            (SELECT COUNT(id) FROM gameplay_lines gpl WHERE gpl.gameplay_id = gp.id) AS NBJoueurs
            FROM gameplay gp 
            INNER JOIN games gm ON (gm.id = gp.game_id)
            ORDER BY gp.date DESC
            LIMIT ' . ($nb) . ';';
       
    
    $gameplays = $database->get_results($q, true);
    return $gameplays;
}

function getNbPlayedGameplays($game_id)
{
    global $database;
    $q = '
            SELECT COUNT(`id`) AS C FROM `gameplay` WHERE `game_id` = ' . ($game_id) . ';';
    $nb = $database->get_row($q, true);
    return $nb;
}

function getNbPlayedGameplaysByPlayers($player_id)
{
    global $database;
    $q = '
            SELECT COUNT(`id`) AS C FROM `gameplay_lines` WHERE `player_id` = ' . ($player_id) . ';';
    $nb = $database->get_row($q, true);
    return $nb;
}


function getAverageScorePerPlayerForGame($game_id)
{
    global $database;
    $q = '
            SELECT COUNT(gp.id) AS nb, p.firstname, p.lastname, ROUND(AVG(gpl.score),0) AS avgs
            FROM gameplay gp 
            INNER JOIN gameplay_lines gpl ON (gpl.gameplay_id = gp.id)
            INNER JOIN games gm ON (gm.id = gp.game_id)
            INNER JOIN players p ON (p.id = gpl.player_id)
            WHERE gp.game_id = ' . ($game_id) . '
            GROUP BY p.id
            ORDER BY avgs DESC';
    $averageScorePerPlayerForGame = $database->get_results($q, true);
    return $averageScorePerPlayerForGame;       
    
}


