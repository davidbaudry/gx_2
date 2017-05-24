<!doctype html>
<html class="no-js" lang="">
    <?php
    include_once '../includes/config.php';
    include_once INC . 'header.php';
       
    //analyse POST
    if(isset($_POST['submit']) && ($_POST['submit'] == 'insert'))
    {
        //var_dump($_POST);
        if($_POST['firstname']){
            insertPlayer($_POST); 
        }
    }
    
    
    ?>
    <article>
        <header>
            <h1>Les joueurs</h1>
        </header>
        <section>
            <form action="" method="post">
                <fieldset class="">
                    <label for="foo">Prénom : </label>
                    <br />
                    <input name="firstname" size="25" type="text">
                    <br />
                    <label for="foo">Nom : </label>
                    <br />
                    <input name="lastname" size="25" type="text">
                    <br />
                    <hr class="hrclear"/>
                    <button class="button1" type="submit" name="submit" value="insert">Ajouter joueur</button>    
                </fieldset>
            </form> 
        </section>
        <section>
            <h2>Liste</h2>
            <p>
                <?php
                    $liste_joueurs = array();
                    $liste_joueurs = playersList();
                    // conserve l'initiale pour la rupture
                    $initiale = null;
                    echo '<ul>';
                    foreach ($liste_joueurs AS $joueur){
                        if($initiale != substr($joueur->firstname, 0, 1))
                        {
                            $initiale = substr($joueur->firstname, 0, 1);
                            echo '<h3>'.$initiale.'</h3>';
                        }
                        // compte les parties de ce jeu
                        $nb_parties_jouees = getNbPlayedGameplaysByPlayers($joueur->id);
                        echo '<li class="cleanli">';
                        echo '<a href="'.LINK_BASE_URL.'content/fiche-joueur.php?g='.$joueur->id.'">';
                        echo ' ';
                        echo $joueur->firstname.' '.$joueur->lastname;
                        echo '</a>';
                        echo ' - <span class="infotxt">'.$nb_parties_jouees->C.' parties jouées</span>';
                        echo '</li>';            
                    }
                    echo '</ul>';
                ?>
            </p>
        </section>
        <footer>
            <h3>article footer h3</h3>
            <p>...</p>
        </footer>
    </article>

    <?php 
        include_once INC . 'footer.php';