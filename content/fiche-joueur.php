<!doctype html>
<html class="no-js" lang="">
    <?php
    include_once '../includes/init.php';
    include_once INC . 'header.php';
    
    $display_players_info = false;
    
    if(isset($_GET['g']))
    {
        $player_id = (int)$_GET['g'];
        if ($player_id)
        {
            // infos sur le jeu
            $player_info = getPlayerFromId($player_id);
            
            // nombre de parties jouées
            $nb_gameplay = getNbPlayedGameplaysByPlayers($player_id);
            
            // joueurs
            if ($nb_gameplay)
            {
                //$players_info = getAverageScorePerPlayerForGame($game_id);
                
            }   
        }
        else
        {
            echo 'Fiche introuvable - ERR 612';
        }
    }
    ?>
    <article>
        <header>
            <h1><?php echo $player_info->firstname.' '.$player_info->lastname; ?></h1>
        </header>
        <section>
            <ul>
                <li class="cleanli"><?php echo $nb_gameplay->C; ?> Parties jouées</li>
            </ul>
        </section>
        
        <section>
            <h3>Jeux</h3>
            <?php
            // recherche les jeux les jouées par ce joueur
            $jeux_joues = getNbPlayedGamesByPlayer($player_id);
            echo '<ul>';
                foreach ($jeux_joues as $jeu)
                {
                    echo '<li class="cleanli">';
                        echo '<a href="'.LINK_BASE_URL.'content/fiche-jeu.php?g='.$jeu->id.'">'.$jeu->name.'</a> : '.$jeu->C.' partie(s).';
                    echo '</li>';
                    echo '<li class="cleanli">';
                        
                        //recherche les % de victoire du joueur pour ce jeu
                        $infos_jeu_joueur = getInfoGamePlayer($jeu->id, $player_info->id);
                        echo '<p>';
                        echo $infos_jeu_joueur;
                        echo '</p>';
                        //echo '<br />';
                        
                    echo '</li>';
                }
                echo '</ul>';
            ?>
           
        </section> 
        
        <footer>
            <h3>test</h3>
            
        </footer>
    </article>


    <?php 
        include_once INC . 'footer.php';


