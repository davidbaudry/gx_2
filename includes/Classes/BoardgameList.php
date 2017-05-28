<?php

/**
 * Created by David
 * Date: 28/05/2017
 * Time: 10:31
 * --
 * Cette classe va permettre de construire et de parcourir des liste s de jeux,
 * en s'appuyant sur des interfaces prédéfinies
 */
class BoardgameList implements SeekableIterator, Countable
{

    private $_boardgame_list;
    private $_position;

    public function __construct(array $boardgame_list)
    {
        self::hydrate($boardgame_list);
    }

    public function hydrate(array $boardgame_list)
    {
        $this->_position = 0;
        foreach ($boardgame_list as $boardgame) {
            try {
                $this->_boardgame_list[] = self::setBoardgameIteration($boardgame);
            } catch (Exception $e) {
                echo 'Exception rencontrée. Message d\'erreur : ', $e->getMessage() . '<br>';
            }
        }
    }

    /*
     * Cette méthode va contrôler les données avant hydratation
     */
    private function setBoardgameIteration($boardgame)
    {
        if (!is_array($boardgame)) {
            throw new ScorerException ('Cette entrée n\'est pas un tableau !');
        }
        // todo : d'autres contrôles ici

        return $boardgame;
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


    /* MÉTHODE DE L'INTERFACE Countable */

    /**
     * Retourne le nombre d'entrées de notre tableau.
     */
    public function count()
    {
        return count($this->_boardgame_list);
    }


}