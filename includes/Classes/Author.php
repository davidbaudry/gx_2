<?php


class Author
{

    private $_id;
    private $_firstname;
    private $_lastname;

    public function __construct(array $author_data)
    {
        $this->hydrate($author_data);
    }

    public function hydrate(array $author_data)
    {
        foreach ($author_data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

    }


    public function getFullName()
    {
        return $this->getFirtname() . ' ' . $this->getLastname();
    }


    /*
     * GETTERS & SETTERS below
     */

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getFirtname()
    {
        return $this->_firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->_lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }







}