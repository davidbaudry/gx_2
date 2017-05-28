<?php

/**
 * Created by : David
 * Date: 27/05/2017
 * Time: 10:46
 */
class PeopleManager
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

    public function getPlayer($player_id)
    {
        // préparation de la requête
        $query = $this->_db->prepare(
            'SELECT 
                `id`, 
                `firstname`, 
                `lastname`,
                `is_player`, 
                `is_starred`
            FROM `people` 
            WHERE `is_player` = 1 AND `id` = :id'
        );
        // Passage de la requête avec les paramètres + test de la validité de la réponse
        if ($query->execute(array('id' => $player_id))) {
            $player_data = $query->fetch();
            return ($player_data);
        } else {
            trigger_error('Player id unknown (pm10)', E_USER_WARNING);
            return false;
        }
    }

    public function getAuthor($author_id)
    {
        // préparation de la requête
        $query = $this->_db->prepare(
            'SELECT 
                `id`, 
                `firstname`, 
                `lastname`,
                `is_author`, 
                `is_starred`
            FROM `people` 
            WHERE `is_author` = 1 AND `id` = :id'
        );
        // Passage de la requête avec les paramètres + test de la validité de la réponse
        if ($query->execute(array('id' => $author_id))) {
            $authors_data = $query->fetch();
            return ($authors_data);
        } else {
            trigger_error('Author id unknown (pm20)', E_USER_WARNING);
            return false;
        }
    }

    public function getAuthorList()
    {
        $pdo_ressource = new Database();
        $db = $pdo_ressource->getCx();

        $query = $db->prepare('
            SELECT id, firstname, lastname
            FROM people
            WHERE is_author IS TRUE
            ORDER BY lastname ASC');
        $query->execute();
        $authors = array();
        while ($author = $query->fetch()) {

            $authors[] = $author;
        }
        return $authors;
    }


}