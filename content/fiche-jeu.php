<!doctype html>
<html class="no-js" lang="">
<?php
include_once '../includes/config.php';
include_once INC . 'header.php';

$display_players_info = false;

if (isset($_GET['g'])) {
    $boardgame_id = (int)$_GET['g'];
    if ($boardgame_id) {

        // L'objet instancié de la classe manager collecte les données
        $boardgame_manager = new BoardgameManager();

        // L'objet instancié de la classe boardgame est hydraté avec les données ransmises par le manager
        $boardgame = new Boardgame($boardgame_manager->get($boardgame_id));


        // todo : Virer ceta ncien code - tout passer en OO
        /*
        $game_info = getGameFromId($game_id);

        // nombre de parties jouées
        $nb_gameplay = getNbPlayedGameplays($game_id);

        // joueurs
        if ($nb_gameplay) {
            $players_info = getAverageScorePerPlayerForGame($game_id);
            $display_players_info = true;
        }
        */
    } else {
        trigger_error('Boardgame unavailabke (fj10)', E_USER_WARNING);
    }
}
?>
<article>
    <header>
        <h2>Fiche n°<span class="invert_bw"><?php echo $boardgame->getId(); ?></span></h2>
    </header>
    <section>
        <h2><?php echo $boardgame->getName(); ?></h2>
        <ul>
            <li class="cleanli">Auteur : <a href="#">
                    <?php echo $boardgame->getAuthor(); ?></a></li>
            <li class="cleanli">Auteur 2 : <a
                    href="#"><?php echo $boardgame->getAuthor_second(); ?></a></li>
            <li class="cleanli">Editeur : <a href="#"><?php echo $boardgame->getEditor(); ?></a>
            </li>
            <li class="cleanli">Est collaboratif
                : <?php echo $boardgame->getIs_collaborative(); ?></li>
            <li class="cleanli">Est une extension
                : <?php echo $boardgame->getIs_extension(); ?></li>
            <li class="cleanli">Le score est inversé
                : <?php echo $boardgame->getHas_invert_score(); ?></li>
        </ul>
    </section>
    <?php
    if ($boardgame->getImg_url()) {
        echo '<img src="' . $boardgame->getImg_url() . '">';
    }
    ?>
    <section>
        <h3>Top scores</h3>
        <?php
        die(':todo');
        if ($display_players_info) {
            $top_scores = getGameTopScores($game_id, 5);
            //var_dump($top_scores);
            echo '<ul>';
            $i = 0;
            foreach ($top_scores as $score) {
                $i++;
                echo '<li class="cleanli">';
                echo $i . ' > ' . $score->firstname . ' ' . $score->lastname . ' : ' . $score->score;
                echo '</li>';
            }
            echo '</ul>';
        }
        ?>
    </section>
    <section>
        <h3>Parties jouées : <?php echo $nb_gameplay->C; ?></h3>
        <?php
        if ($display_players_info) {
            echo '<ul>';
            foreach ($players_info as $player_info) {
                echo '<li class="cleanli">';
                echo $player_info->firstname . ' ' . $player_info->lastname . ' : <b>' . $player_info->nb . '</b> parties, score moyen = ' . $player_info->avgs;
                echo '</li>';
            }
            echo '</ul>';
        }
        ?>
    </section>

    <footer>
        <h3>Toutes les parties de <?php echo $game_info->gamename; ?></h3>
        <?php
        if ($nb_gameplay) {
            $gameplays_list = getGameplaysListFromGameid($game_id);
            echo '<ul>';
            foreach ($gameplays_list as $gameplay) {
                echo '<li class="cleanli">';
                echo 'Partie n°' . $gameplay->id . ', le ' . SqlToTime($gameplay->date) . ' : ';
                // recherche les joueurs et scores
                $gameplayLines = getPlayersFromGameplayId($gameplay->id);
                echo '<ul>';
                foreach ($gameplayLines as $line) {
                    echo '<li class="cleanli">';
                    echo $line->firstname . ' ' . $line->lastname . ' : ' . $line->score;
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


