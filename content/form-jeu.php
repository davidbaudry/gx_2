<!doctype html>
<html class="no-js" lang="">
<?php
include_once '../includes/init.php';
include_once INC . 'header.php';

//$authorList =  authorList();
//$editorList =  editorList();

/*
//analyse POST
if(isset($_POST['submit']) && ($_POST['submit'] == 'insert'))
{
    //var_dump($_POST);
    if($_POST['name']){
        insertGame($_POST);
    }
}
*/


?>

<article>
    <header>
        <h1>Formulaire Jeux (CRUD)</h1>
    </header>

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
                <button class="button1" type="submit" name="submit" value="insert">Ajouter un jeu
                </button>
            </fieldset>
        </form>
    </section>
</article>

<?php
include_once INC . 'footer.php';