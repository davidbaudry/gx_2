<?php

/**
 * Created by David
 * Date: 28/05/2017
 * Time: 10:43
 */
class BoardgameListManager
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
    public function getList()
    {
        // préparation de la requête
        $query = $this->_db->prepare('
            SELECT g.id, g.name AS gamename, g.is_extension, 
                a.firstname, a.lastname, e.name AS editorname
            FROM boardgames g
                INNER JOIN people a ON(a.id = g.author_id and a.is_author IS TRUE)
                INNER JOIN editors e ON(e.id = g.editor_id)
            ORDER BY g.name ASC;'
        );
        if ($query->execute()) {
            while ($result_line = $query->fetch()) {
                $boardgameList_data[] = $result_line;
            }
            return ($boardgameList_data);
        } else {
            trigger_error('Unable to build boardgame list (blm10)', E_USER_WARNING);
            return false;
        }
    }

}