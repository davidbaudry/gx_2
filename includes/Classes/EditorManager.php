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