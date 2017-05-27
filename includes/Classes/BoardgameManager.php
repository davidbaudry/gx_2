<?php

/*
 * Class Manager pour boardgame
 * Responsabilité : Gérer les connexions et les requêtes BDD pour tout ce qui concerne les boardgames
 */

class boardgameManager
{

    private $_db; /// instance de PDO

    public function __construct()
    {
        $pdo_ressource = new Database();
        $this->_db = $pdo_ressource->getCx();
    }



    /*
     * GET + CRUD
     */
    // Fetch des données d'un jeu en particulier
    public function get($boardgame_id)
    {
        // préparation de la requête
        $query = $this->_db->prepare(
            'SELECT 
                `id`, 
                `name`, 
                `author_id`,
                `author_second_id`, 
                `editor_id`, 
                `description`, 
                `is_extension`, 
                `is_collaborative`, 
                `has_invert_score`, 
                `img_url` 
            FROM `boardgames` 
            WHERE `id` = :id'
        );
        // Passage de la requête avec les paramètres + test de la validité de la réponse
        if ($query->execute(array('id' => $boardgame_id))) {
            $boardgame_data = $query->fetch();
            return ($boardgame_data);
        } else {
            trigger_error('Boardgame id unknown (bm20)', E_USER_WARNING);
            return false;
        }
    }

    public function create(Boargame $boardgame)
    {

    }

    public function update(Boardgame $boardgame)
    {

    }

    public function delete(Boardgame $boardgame)
    {

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

}