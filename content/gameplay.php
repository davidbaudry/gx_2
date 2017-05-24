<!doctype html>
<html class="no-js" lang="">
    <?php
    include_once '../includes/config.php';
    include_once INC . 'header.php';
    
    // Déclarations
    $gameplay_step = 0;
    if(isset($_GET['gameplay_step'])){
        $gameplay_step = (int)$_GET['gameplay_step'];
    }

    $display_gameplay_list = true;


    // Etapes
    // 0. Ajouter partie ?
    // 1. Quel Jeu ?
    // 2. Joueurs et scores ?
    // 3. Vérif
    // 4. Terminer

    ?>
    <article>
        <header>
            <h1>Les parties</h1>
        </header>
        <section>
        <?php

        //var_dump($gameplay_step);

        switch ($gameplay_step) {
            case 0 :
                // 0. Ajouter partie ?
                echo '<h2>Enregistrer nouvelle partie</h2>';
                // Afficher bouton
                echo '<a class="button1" href="'.LINK_BASE_URL.'content/gameplay.php?gameplay_step=1">C\'est par ici</a>';
                // Afficher liste dernières parties

                break;
            case 1 :
                // 1. Quel Jeu ?
                echo '<h2>Nouvelle partie : Date et jeu</h2>';
                // Afficher form
                $gamelist = gamesList();
                //var_dump($gamelist);
                ?>
                
                <form action="<?php echo LINK_BASE_URL; ?>content/gameplay.php?gameplay_step=2" method="post">
                    <fieldset class="">
                        <label for="foo">Date : </label>
                        <br />
                        <input autofocus name="date" type="text" placeholder="Date" value="<?php echo date("Y/m/d");?>">
                        <br />
                        <label for="foo">Jeu : </label>
                        <br />
                        <select name="game_id">
                            <?php
                            foreach ($gamelist as $game) {
                            ?>
                                <option value="<?php echo $game->id; ?>"><?php echo $game->gamename; ?></option> 
                            <?php
                            }
                            ?>   
                        </select>
                        <br />
                        Nb joueurs : 
                        <br />
                        <input name="nbjoueurs" size="2" type="text">
                        <hr class="hrclear"/>
                        <button class="button1" type="submit" name="submit" value="insert">Ajouter</button>
                    </fieldset>
                </form>

                <?php
                // Ne pas afficher liste dernières part
                $display_gameplay_list = false;

                break;
            case 2 :
                // 2. Joueurs et scores ?
                 echo '<h2>Joueurs & résultats</h2>';
                // Game resume
                $game = getGameFromId($_POST['game_id']);
                $players = playersList();
                //var_dump($game);
                //var_dump($_POST);
                $nbjoueurs = $_POST['nbjoueurs'];
                // Formulaire
                ?>
                <form action="<?php echo LINK_BASE_URL; ?>content/gameplay.php?gameplay_step=3" method="post">
                    <fieldset class="">
                        <label for="foo">Date : </label>
                        <?php echo $_POST['date']; ?>
                        <input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
                        <br />
                        <label for="foo">Jeu : </label>
                        <?php echo $game->gamename.' ('.$game->firstname.' '.$game->lastname.')'; ?>
                        <input type="hidden" name="game_id" value="<?php echo $game->id; ?>">
                        <hr class="hrclear"/>
                        <?php
                        for($num_joueur = 0 ; $num_joueur < $nbjoueurs ; $num_joueur++){
                            echo '<label>Joueur '.($num_joueur+1).' : </label><br />';
                            ?>
                            <select autofocus name="player#<?php echo $num_joueur; ?>">
                                <?php
                                foreach ($players as $player) {
                                ?>
                                <option value="<?php echo $player->id; ?>"><?php echo $player->firstname.' '.$player->lastname; ?>
                                </option>
                                <?php } ?> 
                             </select><br />
                            <label for="foo">Score : </label><br />
                            <input type="text" name="score#<?php echo $num_joueur; ?>" size="10" >
                            <hr />
                        <?php
                        }
                        ?>   
                        <input type="hidden" name="nbjoueurs" value="<?php echo $nbjoueurs; ?>">
                        <button class="button1" type="submit" name="submit" value="insertnewgameplay">Go</button>
                    </fieldset>
                </form>
                <?php
                // Ne pas afficher liste dernières part
                $display_gameplay_list = false;
                break;
            case 3 :
                // 3. Vérif
                echo '<h2>Partie enregistrée !</h2>';
                if(isset($_POST['submit']) && $_POST['submit'] == 'insertnewgameplay')
                {
                    //var_dump($_POST); 
                    // insert du gameplay
                    $test = insertGameplay($_POST);
                    //global $database;
                    $gameplay_id = $database->lastid();

                    // insert des lignes gameplay joueurs
                    for($i = 0 ; $i < $_POST['nbjoueurs']; $i++)
                    {
                        $player_id = $_POST['player#'.$i];   
                        $score = $_POST['score#'.$i]; 
                        insertGameplayLine($gameplay_id , $player_id, $score); 
                    }
                }
                // Synthèse des éléments collectés à partir de l'id de la partie (gameplay) et OK ou retour
                $gameplay = getGameplayFromId($gameplay_id);

                //var_dump($gameplay);
                // Récap du jeu : 
                ?>
            <ul><span class="cleantitle">Partie n°<?php echo $gameplay[0]->id;?></span>
                     <li class="cleanli">
                        Jeu : <?php echo $gameplay[0]->name;?>
                    </li>
                    <li class="cleanli">
                        Date : <?php echo $gameplay[0]->date;?>
                    </li>
                </ul>
                <ul><span class="cleantitle">Joueurs</span>
                    <?php
                    foreach ($gameplay AS $player_info)
                    {
                        echo '<li class="cleanli">';    
                        echo $player_info->firstname.' '.$player_info->lastname.' Score : '.$player_info->score;
                        echo '</li>';
                    }
                    ?>
                </ul>
                <?php
                break;
            default :
                echo 'ERR 225';
        }

        ?>
        </section>
        <h2>Parties récentes</h2>
        <?php
        if($display_gameplay_list)
        {
            $display_recent_gameplays = displayRecentGameplays($nb=10);
            echo $display_recent_gameplays;
        }
        ?>
        <!--
        <footer>
            <h3>article footer h3</h3>
            <p>...</p>
        </footer>
        -->
    </article>
    <!--
    <aside>
        <h3>aside</h3>
        <p>...</p>
    </aside>
    -->

    <?php 
        include_once INC . 'footer.php';