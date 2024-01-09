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
    public function insert_tag()
    {
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
    public function getTagByName($nom_tag)
    {
        $query = "SELECT * FROM tag WHERE nom_tag = :nom_tag";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nom_tag", $nom_tag, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Tag($result["nom_tag"]);
        } else {
            return null;
        }
    }
    public function update_tag()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $old_nom_tag = $_POST["old_nom_tag"];
            $new_nom_tag = $_POST["new_nom_tag"];
            try {
                $query = "update tag set nom_tag=:new_nom_tag where nom_tag=:old_nom_tag";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':old_nom_tag', $old_nom_tag);
                $stmt->bindParam(':new_nom_tag', $new_nom_tag);
                $stmt->execute();

                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
    }
    public function delete_tag($nom_tag){
        try {
            $query = "delete from tag where nom_tag=:nom_tag";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nom_tag', $nom_tag);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}