<?php

/**
 * Created by David
 * Date: 28/05/2017
 * Time: 10:31
 * --
 * Cette classe va permettre de construire et de parcourir des listes d'auteurs,
 * en s'appuyant sur des interfaces prédéfinies
 */
class AuthorList implements SeekableIterator, Countable
{

    private $_author_list;
    private $_position;

    public function __construct(array $_author_list)
    {
        self::hydrate($_author_list);
    }

    public function hydrate(array $author_list)
    {
        $this->_position = 0;
        foreach ($author_list as $author) {
            try {
                $this->_author_list[] = self::setAuthorIteration($author);
            } catch (Exception $e) {
                echo 'Exception rencontrée. Message d\'erreur : ', $e->getMessage() . '<br>';
            }
        }
    }

    /*
     * Cette méthode va contrôler les données avant hydratation
     */
    private function setAuthorIteration($author)
    {
        if (!is_array($author)) {
            throw new ScorerException ('Cette entrée n\'est pas un tableau !');
        }
        // todo : d'autres contrôles ici

        return $author;
    }

    /**
     * Retourne l'élément courant du tableau.
     */
    public function current()
    {
        return $this->_author_list[$this->_position];
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
        return isset($this->_author_list[$this->_position]);
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
        return count($this->_author_list);
    }


}