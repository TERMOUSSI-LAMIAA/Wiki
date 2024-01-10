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
    public function insert_wiki($email)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $titre = $_POST["titre"];
            $contenu = $_POST["contenu"];
            $wiki_date = $_POST["wiki_date"];
            $fk_cat = $_POST["fk_cat"];
            $img = $_FILES["img"];

            // Check if an image was uploaded
            if ($img["error"] == UPLOAD_ERR_OK) {
                $imgData = file_get_contents($img["tmp_name"]);
            } else {
                // No image provided, set $imgData to null or any default value
                $imgData = null;
            }
            $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
            try {
                $this->db->beginTransaction();

                $query = "INSERT INTO wiki (`titre`, `contenu`, `wiki_date`, `img`, `fk_aut_email`, `fk_cat`) VALUES (:titre, :contenu, :wiki_date, :img, :fk_aut_email, :fk_cat)";
                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':titre', $titre);
                $stmt->bindParam(':contenu', $contenu);
                $stmt->bindParam(':wiki_date', $wiki_date);
                $stmt->bindParam(':img', $imgData, PDO::PARAM_LOB);
                $stmt->bindParam(':fk_aut_email', $email);
                $stmt->bindParam(':fk_cat', $fk_cat);
                $stmt->execute();

                $wikiId = $this->db->lastInsertId();
                foreach ($tags as $tag) {
                    $this->associate_tag_with_wiki($tag, $wikiId);
                }
                // Commit the transaction
                $this->db->commit();
                return true;
            } catch (PDOException $e) {
                $this->db->rollBack();
                echo "Error: " . $e->getMessage();
                return false;
            }
        }

        // Return false if the form is not submitted
        return false;
    }
    private function associate_tag_with_wiki($tag, $wikiId)
    {
        $query = "INSERT INTO wiki_tag (fk_nom_tag, fk_id_w) VALUES (:fk_nom_tag, :fk_id_w)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fk_nom_tag', $tag);
        $stmt->bindParam(':fk_id_w', $wikiId);
        $stmt->execute();
    }
}