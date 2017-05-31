<?php

/**
 * Created by : David
 * Date: 29/05/2017
 * Time: 21:46
 */
class EditorManager
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

    public function getEditor($editor_id)
    {
        // préparation de la requête
        $query = $this->_db->prepare(
            'SELECT 
                `id`, 
                `name`
            FROM `editors` 
            WHERE `id` = :id'
        );
        // Passage de la requête avec les paramètres + test de la validité de la réponse
        if ($query->execute(array('id' => $editor_id))) {
            $editor_data = $query->fetch();
            return ($editor_data);
        } else {
            trigger_error('Editor id unknown (pm25)', E_USER_WARNING);
            return false;
        }
    }



    public function getEditorList()
    {
        $pdo_ressource = new Database();
        $db = $pdo_ressource->getCx();

        $query = $db->prepare('
            SELECT id, name
            FROM editors
            ORDER BY name ASC');
        $query->execute();
        $editors = array();
        while ($editor = $query->fetch()) {
            $editors[] = $editor;
        }
        return $editors;
    }


}