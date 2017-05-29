<?php

/**
 * Created by David
 * Date: 29/05/2017
 * Time: 21:31
 * --
 * Build and browse Editors List
 */
class EditorList implements SeekableIterator, Countable
{

    /**
     * @var
     */
    private
        $_editor_list,
        $_position;

    /**
     * EditorList constructor.
     * @param array $_editor_list
     */
    public function __construct(array $_editor_list)
    {
        self::hydrate($_editor_list);
    }

    /**
     * @param array $editor_list
     */
    public function hydrate(array $editor_list)
    {
        $this->_position = 0;
        foreach ($editor_list as $editor) {
            try {
                $this->_editor_list[] = self::setEditorIteration($editor);
            } catch (Exception $e) {
                echo 'Exception rencontrée. Message d\'erreur : ', $e->getMessage() . '<br>';
            }
        }
    }

    /**
     * @param $editor
     * @return mixed
     * @throws ScorerException
     */
    private function setEditorIteration($editor)
    {
        if (!is_array($editor)) {
            throw new ScorerException ('Cette entrée n\'est pas un tableau !');
        }
        // todo : d'autres contrôles ici

        return $editor;
    }

    /**
     * Retourne l'élément courant du tableau.
     */
    public function current()
    {
        return $this->_editor_list[$this->_position];
    }

    /**
     * Retourne la clé actuelle.
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
        return isset($this->_editor_list[$this->_position]);
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
        return count($this->_editor_list);
    }


}