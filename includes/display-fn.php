<?php

function displayRecentGameplays($nb=10)
{
    $recent_gameplays = getPreviousGameplays($nb);
    $chain = '';
    $chain .= '<ul>';
    foreach ($recent_gameplays AS $gameplay)
    {
        $chain .= '<li class="cleanli">';    
        $chain .= 'le '.$gameplay->date.' : <a href="'.LINK_BASE_URL.'content/fiche-jeu.php?g='.$gameplay->game_id.'">'.$gameplay->name.'</a> - '.$gameplay->NBJoueurs.' joueurs [<a href="#">Partie '.$gameplay->id.'</a>]';
        $chain .= '</li>';
    }
    $chain .= '</ul>';
    
    return $chain;
}
