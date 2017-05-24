<!doctype html>
<html class="no-js" lang="">
    <?php
    include_once '../includes/config.php';
    include_once INC . 'protection.php';
    include_once INC . 'header.php';
    ?>
    <article>
        <header>
            <h1><?php echo SITENAME; ?></h1>
            <p>Enregistrer facilement les parties de jeux de plateau et autres.</p>
        </header>
        <section>
            <h2>Parties récentes</h2>
            <p>
            <?php
            $display_recent_gameplays = displayRecentGameplays($nb=10);
            echo $display_recent_gameplays;
            ?>
            </p>
        </section>

        <footer>
            <h3>article footer h3</h3>
            <p>...</p>
        </footer>
    </article>

    <aside>
        <h3>aside</h3>
        <p>...</p>
    </aside>

    <?php 
        include_once INC . 'footer.php';

