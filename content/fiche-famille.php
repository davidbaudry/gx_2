<!doctype html>
<html class="no-js" lang="">
<?php
include_once '../includes/init.php';
include_once INC . 'header.php';

/***************************
Ce document présente un regroupement de jeux d'une même famille
Ex : Les aventuriers du rail
******************************/

// choix de la famille à regarder
if (isset($_GET['famille']))
{
	$racine_famille = $_GET['famille'];
}
else
{
	$racine_famille = 0;
}

// tableau des familles
$familles = array(
	0 => 'aventuriers du rail',
);

// 1 recherche les jeux de la famille
$q_jeux_famille = '
	SELECT id, name FROM games 
	WHERE name like "'.Securite::bdd($familles[$racine_famille]).'%" 
	ORDER BY name ASC;
';
//echo $q_jeux_famille;
$games = $database->get_results($q_jeux_famille, true);

$tot_gameplays = 0;


?>

<article>
    <header>
        <h1>Famille <?php echo ucfirst($familles[$racine_famille]); ?></h1>
    </header>
    <section>
        <ul>
        	<?php
        	foreach($games as $game)
			{
				echo '<a href="'.LINK_BASE_URL.'content/fiche-jeu.php?g='.$game->id.'">'.$game->name.'</a>';
				echo '<li class="cleanli">';
				echo 'Nombre de parties jouées : ';
				$nb_gp = getNbPlayedGameplays($game->id)->C;
				echo $nb_gp;
				$tot_gameplays += $nb_gp;
				echo '<br />';
				echo 'Meilleurs scores : ';
				$top_scores = getGameTopScores($game->id, 3);
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
                /*
				echo 'Qui a le plus joué : ';
				echo '';
				*/
				echo '<br />';
				echo '</li>';
				echo '<br />';
			}
			?>
        </ul>
    </section>
    
    <footer>
        <h3>Au total, <?php echo $tot_gameplays;?> parties de <?php echo ucfirst($familles[$racine_famille]); ?></h3>
    </footer>
</article>

<?php 
    include_once INC . 'footer.php';