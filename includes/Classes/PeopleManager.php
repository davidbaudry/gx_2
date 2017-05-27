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
    // Fetch des données d'un jeu en particulier
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
            WHERE `id` = :id'
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


}