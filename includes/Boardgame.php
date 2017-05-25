<?php

/*
 * Boardgame class
 */

class boardgame
{
    // constantes de classe
    const NO_AUTHOR = 'Pas d\'auteur';

    // déclaration des attributs
    private $_id;
    private $_name;
    private $_author_id;
    private $_author_second_id;
    private $_editor_id;
    private $_description;
    private $_is_extension;
    private $_is_collaborative;
    private $_has_invert_score;
    private $_img_url;

    public function __construct($known_id)
    {
        // On passe l'id demandé
        $this->_id = $this->setId($known_id);
        // si ok on charge tout depuis la BDD
        if ($this->_id) {
            $this->loadFromDatabase();
        }
    }

    /*
     * La fonction load à pour responsabilité de récupérer en BDD les données liées à l'id
     * Elle appelera ensuite l'hydratation avec le tableau de données
    */
    private function loadFromDatabase()
    {
        // on utilise la classe database surtout pour se connecter, et grace à SPL autoload
        $database = new Database();
        // Récupération de la connexion
        $cx = $database->getCx();
        // préparation de la requête
        $query = $cx->prepare(
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
        if ($query->execute(array('id' => $this->_id))) {
            $boardgame_data = $query->fetch();
            $this->hydrate($boardgame_data);
        } else {
            trigger_error('Boardgame id unknown (bg20)', E_USER_WARNING);
            return false;
        }
    }

    /*
     * La fonction d'hydratation va hydrater les attributs via les setters (contrôle) avec les
     * données venant de la DBB (ou autre)
     */
    private function hydrate(
        $boardgame_data
    ) {
        //print_r($boardgame_data);
        foreach ($boardgame_data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }



    /*
     * Ci-dessous : SETTERS & GETTERS
     */

    // SETTERS
    private function setId($known_id)
    {
        $id = (int)$known_id;
        if ($id) {
            return $id;
        } else {
            trigger_error('Boardgame id undefined (bg10)', E_USER_WARNING);
            return false;
        }
    }

    private function setName($value)
    {
        $this->_name = $value;
    }

    private function setAuthor_id($value)
    {
        $this->_author_id = $value;
    }

    private function setAuthor_second_id($value)
    {
        if ($value) {
            $this->_author_second_id = $value;
        } else {
            $this->_author_second_id = self::NO_AUTHOR;
        }
    }

    private function setEditor_id($value)
    {
        $this->_editor_id = $value;
    }

    private function setDescription($value)
    {
        $this->_description = $value;
    }

    private function setIs_extension($value)
    {
        $this->_is_extension = $value;
    }

    private function setIs_collaborative($value)
    {
        $this->_is_collaborative = $value;
    }

    private function setHas_invert_score($value)
    {
        $this->_has_invert_score = $value;
    }

    private function setImg_url($value)
    {
        $this->_img_url = $value;
    }

    // GETTERS
    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getAuthor()
    {
        // ici on va faire appel à la classe authors afin de retourner les infos pratiques
        return $this->_author_id;
    }

    public function getAuthor_second()
    {
        return $this->_author_second_id;
    }

    public function getEditor()
    {
        return $this->_editor_id;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function getIs_extension()
    {
        return $this->_is_extension;
    }

    public function getIs_collaborative()
    {
        return $this->_is_collaborative;
    }

    public function getHas_invert_score()
    {
        return $this->_has_invert_score;
    }

    public function getImg_url()
    {
        return $this->_img_url;
    }

}