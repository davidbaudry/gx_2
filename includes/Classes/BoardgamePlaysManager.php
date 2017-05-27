<?php

/*
 * Classe ayant pour responsabilité de traiter avec la BDD tout ce qui a trait aux parties jouées
 */

class BoardgamePlaysManager
{

    private $_db; /// instance de PDO

    public function __construct()
    {
        $pdo_ressource = new Database();
        $this->_db = $pdo_ressource->getCx();
    }

    /*
 * Méthodes de listes et diverses (comptage...)
 */

    public static function getTopScores($boardgame_id, $invert_score)
    {
        $pdo_ressource = new Database();
        $db = $pdo_ressource->getCx();
        // todo : simplifier cette partie
        if ($invert_score) {
            $query = $db->prepare('
            SELECT score, firstname, lastname
            FROM gameplay_lines l
                INNER JOIN gameplay g ON(g.id = l.gameplay_id)
                INNER JOIN people p ON(p.id = l.player_id)
            WHERE g.game_id = :id
            ORDER BY score ASC
            LIMIT 10');
        } else {
            $query = $db->prepare('
            SELECT score, firstname, lastname
            FROM gameplay_lines l
                INNER JOIN gameplay g ON(g.id = l.gameplay_id)
                INNER JOIN people p ON(p.id = l.player_id)
            WHERE g.game_id = :id
            ORDER BY score DESC
            LIMIT 10');
        }
        $query->execute(array('id' => $boardgame_id));
        $top_scores = array();
        while ($top_score_line = $query->fetch()) {
            $top_scores[] = $top_score_line;
        }
        return $top_scores;
    }

    public function getNbPlayedGames($boardgame_id)
    {
        $pdo_ressource = new Database();
        $db = $pdo_ressource->getCx();
        $query = $db->prepare('
        SELECT COUNT(`id`) AS NB FROM `gameplay` WHERE `game_id` = :id');
        $query->execute(array('id' => $boardgame_id));
        return $query->fetch();
    }

    public function getAverageScorePerPlayerByBoardgame($boardgame_id)
    {
        $pdo_ressource = new Database();
        $db = $pdo_ressource->getCx();
        $query = $db->prepare('
            SELECT COUNT(gp.id) AS nb, p.firstname, p.lastname, ROUND(AVG(gpl.score),0) AS avgs
            FROM gameplay gp 
                INNER JOIN gameplay_lines gpl ON (gpl.gameplay_id = gp.id)
                INNER JOIN boardgames bg ON (bg.id = gp.game_id)
                INNER JOIN people p ON (p.id = gpl.player_id)
            WHERE gp.game_id = :id
            GROUP BY p.id
            ORDER BY avgs DESC');
        $query->execute(array('id' => $boardgame_id));
        $avg_scores = array();
        while ($avg_score_line = $query->fetch()) {
            $avg_scores[] = $avg_score_line;
        }
        return $avg_scores;
    }

    public function getBoardgamePlaysListByBoardgame($boardgame_id)
    {
        $pdo_ressource = new Database();
        $db = $pdo_ressource->getCx();
        $query = $db->prepare('
            SELECT gp.id, DATE_FORMAT(gp.date, \'%d/%m/%Y\') AS date
            FROM gameplay gp 
            WHERE gp.game_id = :id
            ORDER BY gp.date ASC');
        $query->execute(array('id' => $boardgame_id));
        $played = array();
        while ($plays = $query->fetch()) {
            $played[] = $plays;
        }
        return $played;
    }

    public function getPlayersFromBoardgamePlayId(
        $gameboard_play_id,
        $lowlimit = 0,
        $highlimit = 10
    ) {
        $pdo_ressource = new Database();
        $db = $pdo_ressource->getCx();
        $query = $db->prepare('
            SELECT p.firstname, p.lastname, gpl.score
            FROM gameplay_lines gpl
                INNER JOIN people p ON (p.id = gpl.player_id)
            WHERE gpl.gameplay_id = :id
            ORDER BY score DESC LIMIT :low, :high');
        $query->bindValue(':id', $gameboard_play_id, PDO::PARAM_INT);
        $query->bindValue(':low', intval($lowlimit), PDO::PARAM_INT);
        $query->bindValue(':high', intval($highlimit), PDO::PARAM_INT);
        $query->execute();
        $players = array();
        while ($player_line = $query->fetch()) {
            $players[] = $player_line;
        }
        return $players;
    }
}