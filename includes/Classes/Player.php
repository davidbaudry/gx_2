<?php

/**
 * Created by David
 * Date: 27/05/2017
 * Time: 10:36
 *
 * Final : cette classe n'aura pas de classe fille
 */
final class Player extends People implements PeopleInterface
{

    private $_is_starred;
    private $_is_player;

    public function __construct(array $people_data)
    {
        parent::__construct($people_data);
        // todo: vérifier cette pratique |surcharge de hydrate ?
        self::setIsPlayer(true);
        self::setIsStarred($people_data['is_starred']);
    }

    /*
     * SETTERS & GETTERS propres à Players
     */

    private function setIsStarred($is_starred)
    {
        $this->_is_starred = $is_starred;
    }

    private function setIsPlayer($is_player)
    {
        $this->_is_player = $is_player;
    }

    public function getIsStarred()
    {
        return $this->_is_starred;
    }

    public function getIsPlayer()
    {
        return $this->_is_player;
    }


}