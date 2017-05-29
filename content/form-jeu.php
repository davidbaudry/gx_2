<!doctype html>
<html class="no-js" lang="">
<?php
include_once '../includes/init.php';
include_once INC . 'header.php';

$form_mode = null;

// Form case ?
// todo : simplifier cette partie

// update case : id passed by url (GET) or form return (POST)
if (isset($_POST['submit']) && ($_POST['submit'] === 'update')) {
    $boardgame_id = (int)$_POST['boardgame_id'];
    echo '***test';
    var_dump($_POST);

} else {
    if ((int)$_GET['boardgame'] > 0) {
        $boardgame_id = (int)$_GET['boardgame'];
    }
}

if ($boardgame_id) {
    $form_mode = 'update';
    $form_h1_title = 'Formulaire Jeux [update]';
    // retrieve object boardgame
    // todo : cacher ces appels au manager  (traits ? autre ?)
    $boardgame_manager = new boardgameManager();
    $boardgame_data = $boardgame_manager->get($boardgame_id);
    $boardgame = new boardgame($boardgame_data);
    var_dump($boardgame);
}


// Authors list :
// Seek authors in database
// - using manager class
$people_manager = new PeopleManager();
$author_list_array = $people_manager->getAuthorList();
// array of authors is used to build author list iterator object
$author_list = new EditorList($author_list_array);
$total_number_of_authors = $author_list->count();

// Editor list
$editor_manager = new EditorManager();
$editor_list_array = $editor_manager->getEditorList();
$editor_list = new EditorList($editor_list_array);
$total_number_of_editors = $editor_list->count();
?>

<article>
    <header>
        <h1><?php echo $form_h1_title; ?></h1>
    </header>

    <?php
    if ($form_mode == 'update') {
        ?>
        <section>
            <form action="<?php echo LINK_BASE_URL ?>content/form-jeu.php" method="post">
                <fieldset class="">
                    <label for="foo">Nom : </label>
                    <br/>
                    <input name="name" size="25" type="text" placeholder="Nom du jeu"
                           value="<?php echo $boardgame->getName(); ?>">
                    <br/>
                    <label for="foo">Auteur(s) : (<?php echo $total_number_of_authors; ?>)
                        possibles</label>
                    <br/>
                    <select name="author_id">
                        <?php
                        // Browse the author list using SeekableIterator methods
                        while ($author_list->valid()) {
                            $author = $author_list->current();
                            ?>
                            <option
                                value="<?php echo $author['id']; ?>" <?php echo($author['id'] == $boardgame->getAuthorId() ? 'selected' : ''); ?>><?php echo $author['lastname'] . ' ' . $author['firstname']; ?>
                            </option>
                            <?php
                            $author_list->next();
                        }
                        ?>
                    </select>
                    <select name="author_second_id">
                        <?php
                        $author_list->rewind();
                        while ($author_list->valid()) {
                            $author = $author_list->current();
                            ?>
                            <option
                                value="<?php echo $author['id']; ?>" <?php echo($author['id'] == $boardgame->getAuthorSecondId() ? 'selected' : ''); ?>><?php echo $author['lastname'] . ' ' . $author['firstname']; ?>
                            </option>
                            <?php
                            $author_list->next();
                        }
                        ?>
                    </select>
                    <br/>
                    <label for="foo">Editeur : (<?php echo $total_number_of_editors; ?>)
                        possibles</label>
                    <br/>
                    <select name="editor_id">
                        <?php
                        // Browse the author list using SeekableIterator methods
                        while ($editor_list->valid()) {
                            $editor = $editor_list->current();
                            ?>
                            <option
                                value="<?php echo $editor['id']; ?>" <?php echo($editor['id'] == $boardgame->getEditorId() ? 'selected' : ''); ?>><?php echo $editor['name']; ?></option>
                            <?php
                            $editor_list->next();
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
                    <input type="hidden" name="boardgame_id"
                           value="<?php echo $boardgame->getId(); ?>">
                    <button class="button1" type="submit" name="submit" value="update">Mettre à jour
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