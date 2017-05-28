<!doctype html>
<html class="no-js" lang="">
<?php
include_once '../includes/init.php';
include_once INC . 'header.php';

$form_mode = null;

// Retour de formulaire ?
// todo : simplifier cette partie
if ((isset($_POST)) and (in_array($_POST['submit'], array('update', 'create')))) {
    switch ($_POST['submit']) {
        case 'Create' :

            // contrôles et insertion

            // si ok on passe en mode update
            $form_mode = 'update';

            break;
        case 'Update' :

            // contrôles et mise à jour

            // on reste en mode update
            $form_mode = 'update';

            break;
        default :

    }
} else {
    // on affiche le formulaire en mode create ou en mode update

    if ((isset($_GET['boardgame'])) and ((int)$_GET['boardgame'] > 0)) {

        $boardgame_id = (int)$_GET['boardgame'];
        if ($boardgame_id) {
            $form_mode = 'update';
            $form_h1_title = 'Formulaire Jeux [crUd]';
        }
    }
}

/* PREPARATION DE LA LISTE DES AUTEURS */

// on va rechercher la liste des auteurs présents en database
// - en utilisant le manager
$people_manager = new PeopleManager();
// - puis la méthode get de ce manager
$author_list_array = $people_manager->getAuthorList();
$author_list = new AuthorList($author_list_array);
$total_number_of_authors = $author_list->count();

while ($author_list->valid()) {
    print_r($author_list->current());
    $author_list->next();
}


//$editorList =  editorList();

?>

<article>
    <header>
        <h1><?php echo $form_h1_title; ?></h1>
    </header>

    <?php
    if ($form_mode == 'update') {
        ?>

        <section>
            <form action="" method="post">
                <fieldset class="">
                    <label for="foo">Nom : </label>
                    <br/>
                    <input name="name" size="25" type="text" placeholder="Nom du jeu">
                    <br/>
                    <label for="foo">Auteur : </label>
                    <br/>
                    <select name="author_id">
                        <?php
                        foreach ($authorList as $author) {
                            ?>
                            <option
                                value="<?php echo $author->id; ?>"><?php echo $author->firstname . ' ' . $author->lastname; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <br/>
                    <label for="foo">Editeur : </label>
                    <br/>
                    <select name="editor_id">
                        <?php
                        foreach ($editorList as $editor) {
                            ?>
                            <option
                                value="<?php echo $editor->id; ?>"><?php echo $editor->name; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <br/>
                    <label for="foo">Extension ?</label><br/>
                    <input type="radio" name="is_extension" value="1">Oui
                    <input type="radio" name="is_extension" value="0" checked>Non
                    <br/>
                    <label for="foo">Collaboratif ?</label><br/>
                    <input type="radio" name="is_collaborative" value="1">Oui
                    <input type="radio" name="is_collaborative" value="0" checked>Non
                    <br/>
                    <label for="foo">Scores inversés ?</label><br/>
                    <input type="radio" name="has_invert_score" value="1">Oui
                    <input type="radio" name="has_invert_score" value="0" checked>Non
                    <br/>
                    <input name="description" size="25" type="hidden" value="...">
                    <hr class="hrclear"/>
                    <button class="button1" type="submit" name="submit" value="insert">Ajouter un
                        jeu
                    </button>
                </fieldset>
            </form>
        </section>

        <?php
    }
    ?>
</article>

<?php
include_once INC . 'footer.php';