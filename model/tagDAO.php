<?php
require_once 'connection/connexion.php';
require_once 'model/tagModel.php';
class TagDAO
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_tag()
    {
        $query = "SELECT * FROM tag";
        $stmt = $this->db->query($query);
        $stmt->execute();
        $tagData = $stmt->fetchAll();
        $tags = array();
        foreach ($tagData as $B) {
            $tags[] = new Tag($B["nom_tag"]);
        }
        return $tags;
    }
}