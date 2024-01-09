<?php
require_once 'connection/connexion.php';
require_once 'model/wikiModel.php';
class WikiDAO
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_wiki()
    {
        $query = "SELECT * FROM wiki where isArchive=0";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $wikiData = $stmt->fetchAll();
        $wikis = array();
        foreach ($wikiData as $B) {
            $wikis[] = new Wiki($B["id_w"], $B["titre"], $B["contenu"], $B["wiki_date"], $B["isArchive"], $B["img"], $B["fk_aut_email"], $B["fk_cat"]);
        }
        return $wikis;
    }
    public function archive_wiki($id_w)
    {
        try {
            $query = "update wiki set isArchive=1 where id_w=:id_w";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_w', $id_w);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}