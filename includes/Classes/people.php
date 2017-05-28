<?php

/**
 * Created by David
 * Date: 27/05/2017
 * Time: 10:26
 *
 * Abstract class : Il faudra instancier des auteurs ou des joueurs mais pas directement des peoples
 *
 */
abstract class People implements PeopleInterface
{

    private $_id;
    private $_firstname;
    private $_lastname;

    public function __construct(array $people_data)
    {
        $this->hydrate($people_data);
    }

    /*
     * La fonction d'hydratation va alimenter les attributs via les setters (donc contrôle) avec les
     * données venant de la DBB (ou autre)
     */
    public function hydrate(array $people_data)
    {
        if ($people_data) {
            foreach ($people_data as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        } else {
            trigger_error('People id unknown (pe30)', E_USER_WARNING);
            $this->setName('Unknown');
            return false;
        }
    }


    /*
     * SETTERS & GETTERS
     */
    /*
    public function __get($attribut_name)
    {
        return $this->$attribut_name;
    }
    */

    protected function setId($id)
    {
        $this->_id = $id;
    }

    protected function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    protected function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getFirstname()
    {
        return $this->_firstname;
    }

    public function getLastname()
    {
        return $this->_lastname;
    }

}