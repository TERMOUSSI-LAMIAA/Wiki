<?php
require_once 'connection/connexion.php';
require_once 'model/wikiModel.php';
class UtilisateurDAO
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_wiki()
    {
        $query = "SELECT * FROM wiki";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $wikiData = $stmt->fetchAll();
        $wikis = array();
        foreach ($wikiData as $B) {
            $wikis[] = new Wiki($B["id_w"],$B["titre"],$B["contenu"],$B["wiki_date"],$B["isArchive"],$B["img"],$B["fk_aut_email"],$B["fk_cat"]);
        }
        return $wikis;
    }
}