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
    public function insert_tag(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom_tag = $_POST["nom_tag"];
            try {
                $query = "INSERT INTO tag (nom_tag) VALUES (:nom_tag)";
                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':nom_tag', $nom_tag);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
        // Return false if the form is not submitted
        return false;
    }
}