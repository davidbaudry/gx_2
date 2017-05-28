<!doctype html>
<html class="no-js" lang="">
<?php
include_once '../includes/init.php';
include_once INC . 'header.php';
?>
<a name="top"></a>
<article>
    <?php
    /* PREPARATION DE LA LISTE DE JEUX */

    // on va rechercher la liste des jeux présents en database
    // - en utilisant le manager
    $boardgame_list_manager = new BoardgameListManager();
    // - puis la méthode get de ce manager
    $boardgame_list_array = $boardgame_list_manager->getList();
    $boardgame_list = new BoardgameList($boardgame_list_array);
    $total_number_of_boardgames = $boardgame_list->count();
    ?>
    <header>
        <h1>Liste des <?php echo $total_number_of_boardgames; ?> jeux</h1>
    </header>

    <section>
        Aller à : <?php
        foreach (range('A', 'Z') as $lettre) {
            echo '<a href="#' . $lettre . '">' . $lettre . '</a> ';
        }
        ?>
        <ul>
            <?php
            // préparation d'une rupture lorsque l'on change d'initiale
            $initiale = null;
            // parcours de la liste
            while ($boardgame_list->valid()) {

                $boardgame_current = $boardgame_list->current();

                if ($initiale != substr($boardgame_current['gamename'], 0, 1)) {
                    $initiale = substr($boardgame_current['gamename'], 0, 1);
                    echo '<h3><a id="' . $initiale . '">' . $initiale . '</a> - <a href="#top">&uarr;</a></a></h3>';
                }

                echo '<li class="cleanli">';
                echo '<span class="invert_bw"> ' . str_pad($boardgame_current['id'], 3, "0",
                        STR_PAD_LEFT) . '</span>';
                echo '  - ';
                //echo '<a href="' . LINK_BASE_URL . 'content/fiche-jeu.php?g=' . $boardgame_current['id'] . '">' . $boardgame_current['gamename'] . '</a>';
                echo '<strong>' . $boardgame_current['gamename'] . '</strong>';
                echo '  - ';
                echo '(';
                echo $boardgame_current['firstname'] . ' ' . $boardgame_current['lastname'];
                echo ')';
                echo ' - ';
                echo $boardgame_current['editorname'];
                if ($boardgame_current['is_extension']) {
                    echo ' (e)';
                }
                echo ' - ';
                echo '<a href="' . LINK_BASE_URL . 'content/fiche-jeu.php?g=' . $boardgame_current['id'] . '">Fiche</a>';
                echo ' - ';
                echo '<a href="' . LINK_BASE_URL . 'content/form-jeu.php?g=' . $boardgame_current['id'] . '">Form</a>';

                // todo: explorer ce bout : echo ' - <span class="infotxt">' . $boardgame_current['C'] . ' parties jouées</span>';
                echo '</li>';

                $boardgame_list->next();

            }
            ?>
        </ul>
    </section>
</article>

<aside>
    <section>
        <h2>Familles</h2>
        <?php echo '<a href="' . LINK_BASE_URL . 'content/fiche-famille.php?famille=0">Aventuriers du rail</a>'; ?>
    </section>
    <section>
        <h2>Create</h2>
        <?php echo '<a href="' . LINK_BASE_URL . 'content/form-jeu.php?create">Créer nouvelle fiche de jeu</a>'; ?>
    </section>
</aside>

<?php
include_once INC . 'footer.php';