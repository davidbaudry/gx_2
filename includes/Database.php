<?php

/*
 * Une simple classe de connexion à la base de données
 */

class Database
{

    private $_db_host;
    private $_db_user;
    private $_db_name;
    private $_db_pass;
    private $_cx;

    public function __construct()
    {
        $this->_db_host = DB_HOST;
        $this->_db_user = DB_USER;
        $this->_db_name = DB_NAME;
        $this->_db_pass = DB_PASS;
        $this->_cx = new PDO('mysql:host=' . $this->_db_host . ';dbname=' . $this->_db_name . ';charset=utf8',
            $this->_db_user, $this->_db_pass);
    }

    public function getCx()
    {
        return $this->_cx;
    }

}