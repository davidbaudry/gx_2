<?php

/*
 * Class Manager pour boardgame
 * Responsabilité : Gérer les connexions et les requêtes BDD pour tout ce qui concerne les boardgames
 */

class boardgameManager
{

    private $_db; /// instance de PDO

    public function __construct()
    {
        $pdo_ressource = new Database();
        $this->_db = $pdo_ressource->getCx();
    }



    /*
     * GET + CRUD
     */
    // Fetch des données d'un jeu en particulier
    public function get($boardgame_id)
    {
        // préparation de la requête
        $query = $this->_db->prepare(
            'SELECT 
                `id`, 
                `name`, 
                `author_id`,
                `author_second_id`, 
                `editor_id`, 
                `description`, 
                `is_extension`, 
                `is_collaborative`, 
                `has_invert_score`, 
                `img_url` 
            FROM `boardgames` 
            WHERE `id` = :id'
        );
        // Passage de la requête avec les paramètres + test de la validité de la réponse
        if ($query->execute(array('id' => $boardgame_id))) {
            $boardgame_data = $query->fetch();
            return ($boardgame_data);
        } else {
            trigger_error('Boardgame id unknown (bm20)', E_USER_WARNING);
            return false;
        }
    }

    public function create(Boargame $boardgame)
    {

    }

    public function update(Boardgame $boardgame)
    {
        /*
         *
         */
        $name = $boardgame->getName();
        $is_extension = $boardgame->getIs_extension();
        $author_id = $boardgame->getAuthorId();
        $author_second_id = $boardgame->getAuthorSecondId();
        $editor_id = $boardgame->getEditorId();
        $description = $boardgame->getDescription();
        $is_collaborative = $boardgame->getIs_collaborative();
        $has_invert_score = $boardgame->getHas_invert_score();
        $img_url = $boardgame->getImg_url();
        $id = $boardgame->getId();

        // préparation de la requête
        $query = $this->_db->prepare('
            UPDATE `boardgames` SET 
            `name` = :name, 
            `is_extension` = :is_extension, 
            `author_id` = :author_id, 
            `author_second_id` = :author_second_id, 
            `editor_id` = :editor_id,
            `description` = :description,
            `is_collaborative` = :is_collaborative,
            `has_invert_score` = :has_invert_score,
            `img_url` = :img_url
            WHERE `boardgames`.`id` = :id;'
        );

        $query->bindParam('name', $name, PDO::PARAM_STR);
        $query->bindParam('is_extension', $is_extension, PDO::PARAM_BOOL);
        $query->bindParam('author_id', $author_id, PDO::PARAM_INT);
        $query->bindParam('author_second_id', $author_second_id, PDO::PARAM_INT);
        $query->bindParam('editor_id', $editor_id, PDO::PARAM_INT);
        $query->bindParam('description', $description, PDO::PARAM_STR);
        $query->bindParam('is_collaborative', $is_collaborative, PDO::PARAM_BOOL);
        $query->bindParam('has_invert_score', $has_invert_score, PDO::PARAM_BOOL);
        $query->bindParam('img_url', $img_url, PDO::PARAM_STR);
        $query->bindParam('id', $id, PDO::PARAM_INT);
        if ($query->execute()) {
            return true;
        }

        trigger_error('Boardgame id unknown (bm20)', E_USER_WARNING);
        return false;

    }

    public function delete(Boardgame $boardgame)
    {

    }


}