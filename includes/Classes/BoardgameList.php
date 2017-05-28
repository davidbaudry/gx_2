<?php

/**
 * Created by David
 * Date: 28/05/2017
 * Time: 10:31
 * --
 * Cette classe va permettre de construire et de parcourir des liste s de jeux,
 * en s'appuyant sur des interfaces prédéfinies
 */
class BoardgameList implements SeekableIterator
{

    private $_boardgame_list;
    private $_position;

    public function __construct(array $boardgame_list)
    {
        self::hydrate($boardgame_list);
    }

    public function hydrate(array $boardgame_list)
    {

    }

    /**
     * Retourne l'élément courant du tableau.
     */
    public function current()
    {
        return $this->_boardgame_list[$this->_position];
    }

    /**
     * Retourne la clé actuelle (c'est la même que la position dans notre cas).
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * Déplace le curseur vers l'élément suivant.
     */
    public function next()
    {
        $this->_position++;
    }

    /**
     * Remet la position du curseur à 0.
     */
    public function rewind()
    {
        $this->_position = 0;
    }

    /**
     * Permet de tester si la position actuelle est valide.
     */
    public function valid()
    {
        return isset($this->_boardgame_list[$this->_position]);
    }

    /**
     * Déplace le curseur interne.
     */
    public function seek($position)
    {
        $old_position = $this->_position;
        $this->_position = $position;

        if (!$this->valid()) {
            trigger_error('La position spécifiée n\'est pas valide', E_USER_WARNING);
            $this->_position = $old_position;
        }
    }


}