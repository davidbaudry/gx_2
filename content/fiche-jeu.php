<!doctype html>
<html class="no-js" lang="">
<?php
include_once '../includes/init.php';
include_once INC . 'header.php';

use Michelf\Markdown;

$display_players_info = false;

if ((isset($_GET['boardgame'])) and ((int)$_GET['boardgame'] > 0)) {
    $boardgame_id = (int)$_GET['boardgame'];
    if ($boardgame_id) {

        // L'objet instancié de la classe manager collecte les données
        $boardgame_manager = new BoardgameManager();

        // L'objet instancié de la classe boardgame est hydraté avec les données transmises par le manager
        $boardgame = new Boardgame($boardgame_manager->get($boardgame_id));

        // On a également besoin d'un manager pour le sparties
        $boardgame_plays_manager = new GameplayManager();

        ?>
        <article>
            <header>
                <h1>
                    <span
                        class="invert_bw"><?php echo $boardgame->getId(); ?></span> <?php echo $boardgame->getName(); ?>
                </h1>
            </header>
            > <a
                href="<?php echo LINK_BASE_URL; ?>content/form-jeu.php?boardgame=<?php echo $boardgame->getId(); ?>">Modifier</a>
            <section>
                <ul>
                    <?php
                    if ($boardgame->getImg_url()) {
                        echo '<img src="' . $boardgame->getImg_url() . '">';
                    }
                    ?>
                    <li class="cleanli">
                        <?php echo Markdown::defaultTransform($boardgame->getDescription()); ?>
                    </li>
                    <li class="cleanli">
                        Auteur : <a href="#"><?php echo $boardgame->getAuthor(); ?></a>
                    </li>
                    <li class="cleanli">
                        Auteur 2 : <a href="#"><?php echo $boardgame->getAuthorSecond(); ?></a>
                    </li>
                    <li class="cleanli">
                        Editeur : <a href="#"><?php echo $boardgame->getEditor(); ?></a>
                    </li>
                    <li class="cleanli">
                        Est collaboratif : <?php echo $boardgame->getIs_collaborative(); ?>
                    </li>
                    <li class="cleanli">
                        Est une extension : <?php echo $boardgame->getIs_extension(); ?>
                    </li>
                    <li class="cleanli">
                        Le score est inversé : <?php echo $boardgame->getHas_invert_score(); ?>
                    </li>
                </ul>
            </section>

            <h2>Les parties & les joueurs :</h2>
            <section>
                <?php
                // On utilise une méthode statique de BoardgameManager pour rechercher le nombre de parties jouées :
                $boardgame_plays = $boardgame_plays_manager->getNbPlayedGames($boardgame->getId());
                ?>
                <h3>Parties jouées : <?php echo $boardgame_plays['NB']; ?></h3>
            </section>

            <!-- Section présentant les meilleurs scores à ce jeu -->
            <section>
                <h3>Top scores</h3>
                <?php
                // On utilise une méthode statique de BoardgameManager pour rechercher les meilleurs scores :
                $top_scores = $boardgame_plays_manager::getTopScores($boardgame->getId(),
                    $boardgame->getHas_invert_score());
                // display
                echo '<ul>';
                $compteur = 1;
                foreach ($top_scores as $score) {
                    echo '<li class="cleanli">';
                    echo $compteur++ . ' : ' . $score['firstname'] . ' ' . $score['lastname'] . ' : ' . $score['score'];
                    echo '</li>';
                }
                echo '</ul>';

                ?>
            </section>

            <section>
                <h3>Nombre de parties et scores moyens</h3>
                <?php
                // joueurs
                if ($boardgame_plays['NB']) {
                    $players_average_scores = $boardgame_plays_manager->getAverageScorePerPlayerByBoardgame($boardgame->getId());
                }
                // display
                echo '<ul>';
                foreach ($players_average_scores as $player_average_score) {
                    echo '<li class="cleanli">';
                    echo $player_average_score['firstname'] . ' ' . $player_average_score['lastname'] . ' : <b>' . $player_average_score['nb'] . '</b> parties, score moyen = ' . $player_average_score['avgs'];
                    echo '</li>';
                }
                echo '</ul>';
                ?>
            </section>

            <section>
                <h3>Toutes les parties de <?php echo $boardgame->getName(); ?></h3>
                <?php
                if ($boardgame_plays['NB']) {
                    $gameboard_plays_list = $boardgame_plays_manager->getBoardgamePlaysListByBoardgame($boardgame->getId());
                    echo '<ul>';
                    foreach ($gameboard_plays_list as $gameboard_play) {
                        echo '<li class="cleanli">';
                        echo '<strong>Partie n°' . $gameboard_play['id'] . ', le ' . $gameboard_play['date'] . ' : </strong>';
                        echo '</li>';
                        // recherche les joueurs et scores
                        $boardgame_play_lines = $boardgame_plays_manager->getPlayersFromBoardgamePlayId($gameboard_play['id']);
                        foreach ($boardgame_play_lines as $boardgame_play_line) {
                            echo '<li class="cleanli">';
                            echo $boardgame_play_line['firstname'] . ' ' . $boardgame_play_line['lastname'] . ' : ' . $boardgame_play_line['score'];
                            echo '</li>';
                        }
                    }
                    echo '</ul>';
                }
                ?>
            </section>
        </article>

        <?php

    } else {
        trigger_error('Boardgame unavailabke (fj10)', E_USER_WARNING);
        echo 'Jeu non trouvé.';
    }
} else {
    trigger_error('Boardgame id unknown (fj20)', E_USER_WARNING);
    echo 'Jeu non trouvé.';
}
?>
<aside>
    <h3>aside</h3>
    <p>...</p>
</aside>
<?php

include_once INC . 'footer.php';