<?php

/*
 * Boardgame class
 */

class boardgame implements BoardgameInterface
{
    use frenchDates;
    
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

    public function __construct(array $boardgame_data)
    {
        $this->hydrate($boardgame_data);
    }

    /*
     * La fonction d'hydratation va hydrater les attributs via les setters (contrôle) avec les
     * données venant de la DBB (ou autre)
     */
    public function hydrate(array $boardgame_data)
    {
        if ($boardgame_data) {
            foreach ($boardgame_data as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        } else {
            trigger_error('Boardgame id unknown (bg30)', E_USER_WARNING);
            $this->setName('Unknown');
            return false;
        }
    }


    /*
     * MAGICs
     */
    public function __isset($attribut_name)
    {
        return isset($this->$attribut_name);
    }

    public function __unset($attribut_name)
    {
        if (isset($this->$attribut_name)) {
            unset($this->$attribut_name);
        }
    }

    public function __call($nom, $arguments)
    {
        echo 'La méthode <strong>', $nom, '</strong> a été appelée alors qu\'elle n\'existe pas ! Ses arguments étaient les suivants : <strong>', implode($arguments,
            '</strong>, <strong>'), '</strong><br />';
    }

    public function __get($name)
    {
        echo "Récupération de '$name'\n";
        if (isset($this->$name)) {
            return $this->$name;
        }

        $trace = debug_backtrace();
        trigger_error(
            'Propriété non-définie via __get() : ' . $name .
            ' dans ' . $trace[0]['file'] .
            ' à la ligne ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }



    /*
     * Ci-dessous : SETTERS & GETTERS
     */

    // SETTERS
    private function setId($value)
    {
        $id = (int)$value;
        if ($id) {
            $this->_id = $id;
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