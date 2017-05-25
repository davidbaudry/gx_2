<?php

/*
 * Class Manager pour boardgame
 * Responsabilité : Gérer lea connexions et les requêtes BDD pour tout ce qui concerne les boardgames
 */

class boardgameManager
{

    private $_db; /// instance de PDO

    public function __construct()
    {
        $pdo_ressource = new Database();
        $this->_db = $pdo_ressource->getCx();
    }

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
            FROM `games` 
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

    public function add(Boargame $boardgame)
    {

    }

    public function update(Boardgame $boardgame)
    {

    }

    public function delete(Boardgame $boardgame)
    {

    }

}