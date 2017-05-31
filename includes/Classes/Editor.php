<?php


class Editor
{

    private $_id;
    private $_name;

    public function __construct(array $editor_data)
    {
        $this->hydrate($editor_data);
    }

    public function hydrate(array $editor_data)
    {
        foreach ($editor_data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

    }

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
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }


    /*
     * GETTERS & SETTERS
     */
    

}