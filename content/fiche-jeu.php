<!doctype html>
<html class="no-js" lang="">
    <?php
    include_once '../includes/config.php';
    include_once INC . 'header.php';
    
    $display_players_info = false;
    
    if(isset($_GET['g']))
    {
        $game_id = (int)$_GET['g'];
        if ($game_id)
        {
            // infos sur le jeu
            $game_info = getGameFromId($game_id);
            
            // nombre de parties jouées
            $nb_gameplay = getNbPlayedGameplays($game_id);
            
            // joueurs
            if ($nb_gameplay)
            {
                $players_info = getAverageScorePerPlayerForGame($game_id);
                $display_players_info = true;
            }   
        }
        else
        {
            echo 'Fiche introuvable - ERR 229';
        }
    }
    ?>
    <article>
        <header>
            <h1><?php echo $game_info->gamename; ?></h1>
        </header>
        <section>
            <h2>Fiche n°<?php echo $game_id; ?></h2>
            <ul>
                <li class="cleanli">Auteur : <a href="#"><?php echo $game_info->firstname.' '.$game_info->lastname; ?></a></li>
                <li class="cleanli">Editeur : <a href="#"><?php echo $game_info->editorname; ?></a></li>
                <li class="cleanli">Est collaboratif : <?php echo $game_info->is_collaborative; ?></li>
                <li class="cleanli">Est une extension : <?php echo $game_info->is_extension; ?></li>
                <li class="cleanli">Le score est inversé : <?php echo $game_info->has_invert_score; ?></li> 
            </ul>
        </section>
        <?php
        if($game_info->img_url)
        {
            echo '<img src="'.$game_info->img_url.'">';
        }
        ?>
        <section>
            <h3>Top scores</h3>
            <?php
            if($display_players_info)
            {
                $top_scores = getGameTopScores($game_id, 5);
                //var_dump($top_scores);
                echo '<ul>';
                $i = 0;
                foreach ($top_scores as $score)
                {
                    $i++;
                    echo '<li class="cleanli">';
                    echo $i.' > '.$score->firstname.' '.$score->lastname.' : '.$score->score;
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </section> 
        <section>
            <h3>Parties jouées : <?php echo $nb_gameplay->C; ?></h3>
            <?php
            if($display_players_info)
            {
                echo '<ul>';
                foreach ($players_info as $player_info)
                {
                    echo '<li class="cleanli">';
                    echo $player_info->firstname.' '.$player_info->lastname.' : <b>'.$player_info->nb.'</b> parties, score moyen = '.$player_info->avgs;
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </section> 

        <footer>
            <h3>Toutes les parties de <?php echo $game_info->gamename; ?></h3>
            <?php
            if ($nb_gameplay)
            {
                $gameplays_list = getGameplaysListFromGameid($game_id);
                echo '<ul>';
                foreach ($gameplays_list as $gameplay)
                {
                    echo '<li class="cleanli">';
                        echo 'Partie n°'.$gameplay->id.', le '.SqlToTime($gameplay->date).' : ';
                        // recherche les joueurs et scores
                        $gameplayLines = getPlayersFromGameplayId($gameplay->id);
                        echo '<ul>';
                            foreach ($gameplayLines as $line)
                            {
                                echo '<li class="cleanli">';  
                                    echo $line->firstname.' '.$line->lastname.' : '.$line->score;
                                echo '</li>';
                            }
                        echo '</ul>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </footer>
    </article>

    <aside>
        <h3>aside</h3>
        <p>...</p>
    </aside>

    <?php 
        include_once INC . 'footer.php';


