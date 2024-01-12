<?php
require_once 'connection/connexion.php';
require_once 'model/wikiModel.php';
require_once 'model/tagDAO.php';
class WikiDAO
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_wiki($email = "", $action = "")//role
    {
        $tagDAO = new TagDAO();
        $query = "SELECT * FROM wiki where isArchive=0";
        if (!empty($email)) {
            $query .= " AND fk_aut_email = :email";
        }
        if ($action === 'home') {
            $query .= " order by wiki_date DESC LIMIT 4";
        }
        $stmt = $this->db->prepare($query);
        if (!empty($email)) {
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        }
        $stmt->execute();
        $wikiData = $stmt->fetchAll();

        $wikis = array();
        foreach ($wikiData as $B) {
            $tags = array();
            $wiki = new Wiki($B["id_w"], $B["titre"], $B["contenu"], $B["wiki_date"], $B["isArchive"], $B["img"], $B["fk_aut_email"], $B["fk_cat"]);

            $tags = $tagDAO->getTagsByWiki($B["id_w"]);
            // echo "wikis:";
            // print_r($tags);
            // echo "<br>";
            $wiki->setTags($tags);
            $wikis[] = $wiki;
        }

        return $wikis;
    }
    public function get_wikiByID($id_w)
    {
        $tagDAO = new TagDAO();
        $query = "SELECT * FROM wiki WHERE id_w = :id AND isArchive = 0";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id_w, PDO::PARAM_INT);
        $stmt->execute();
        $wikiData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($wikiData) {
            $tags = $tagDAO->getTagsByWiki($wikiData["id_w"]);
            $wiki = new Wiki(
                $wikiData["id_w"],
                $wikiData["titre"],
                $wikiData["contenu"],
                $wikiData["wiki_date"],
                $wikiData["isArchive"],
                $wikiData["img"],
                $wikiData["fk_aut_email"],
                $wikiData["fk_cat"]
            );
            $wiki->setTags($tags);
            return $wiki;
        }
        return null; //  wiki with given ID is not found
    }
    public function searchByTitleTagCatg($searchVal)
    {
        try {
            $query = "SELECT
                        tbl.*,
                        wwt.fk_nom_tag
                    FROM
                        (
                        SELECT
                            w.*,
                            c.nom_cat
                        FROM
                            wiki w
                        LEFT JOIN categorie c ON
                            w.fk_cat = c.nom_cat
                        LEFT JOIN wiki_tag wt ON
                            w.id_w = wt.fk_id_w AND wt.fk_nom_tag LIKE :searchVal
                        WHERE
                            w.isArchive = 0 AND(
                                w.titre LIKE :searchVal OR wt.fk_nom_tag LIKE :searchVal OR c.nom_cat LIKE :searchVal
                            )
                    ) AS tbl
                    LEFT JOIN wiki_tag wwt ON
                        tbl.id_w = wwt.fk_id_w  ORDER BY `tbl`.`id_w` ASC;";
            $stmt = $this->db->prepare($query);
            $searchVal = '%' . $searchVal . '%';
            $stmt->bindParam(':searchVal', $searchVal, PDO::PARAM_STR);
            $stmt->execute();
            $wikiData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $wikis = array_values(
                array_reduce($wikiData, function ($carry, $wiki) {

                    $id = $wiki['id_w'];
                    $tag = $wiki['fk_nom_tag'];

                    if (!isset($carry[$id])) {
                        $carry[$id] = [
                            'id' => $wiki['id_w'],
                            'titre' => $wiki['titre'],
                            'contenu' => $wiki['contenu'],
                            'wiki_date' => $wiki['wiki_date'],
                            'fk_aut_email' => $wiki['fk_aut_email'],
                            'fk_cat' => $wiki['fk_cat'],
                            'base64Image' => base64_encode($wiki['img']),
                            'tags' => $tag ? [$tag] : [],
                        ];
                    } else {
                        if ($tag)
                            $carry[$id]['tags'][] = $tag;
                    }

                    return $carry;
                }, [])
            );
            // echo '<pre>';
            // print_r($wikis);
            // echo '</pre>';
            return $wikis;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
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
    public function updt_wiki($id_w, $email)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $titre = $_POST["titre"];
            $contenu = $_POST["contenu"];
            $wiki_date = $_POST["wiki_date"];
            $fk_cat = $_POST["fk_cat"];
            $img = $_FILES["img"];

            if ($img["error"] == UPLOAD_ERR_OK) {
                $imgData = file_get_contents($img["tmp_name"]);
            } else {
                $imgData = null;
            }
            $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
            try {
                $this->db->beginTransaction();

                // $deleteTagsQuery = "DELETE FROM wiki_tag WHERE fk_id_w = :id_w";
                // $deleteTagsStmt = $this->db->prepare($deleteTagsQuery);
                // $deleteTagsStmt->bindParam(':id_w', $id_w, PDO::PARAM_INT);
                // $deleteTagsStmt->execute();

                $query = "update wiki set titre=:titre ,contenu=:contenu,wiki_date=:wiki_date,img=:img,fk_aut_email=:fk_aut_email,fk_cat=:fk_cat where id_w=:id_w";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':titre', $titre);
                $stmt->bindParam(':contenu', $contenu);
                $stmt->bindParam(':wiki_date', $wiki_date);
                $stmt->bindParam(':img', $imgData, PDO::PARAM_LOB);
                $stmt->bindParam(':fk_aut_email', $email);
                $stmt->bindParam(':fk_cat', $fk_cat);
                $stmt->bindParam(':id_w', $id_w, PDO::PARAM_INT);
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
    }
    public function delete_wiki($id_w){
        try {
            $query = "delete from wiki where id_w=:id_w";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_w', $id_w);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    private function associate_tag_with_wiki($tag, $wikiId)
    {
        $query = "INSERT INTO wiki_tag (fk_nom_tag, fk_id_w) VALUES (:fk_nom_tag, :fk_id_w)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':fk_nom_tag', $tag);
        $stmt->bindParam(':fk_id_w', $wikiId);
        $stmt->execute();
    }

    public function getTagsForWiki($id_w) //not working with it ?!
    {
        $query = "SELECT t.nom_tag
                FROM tag t
                JOIN wiki_tag wt ON t.nom_tag = wt.fk_nom_tag
                WHERE wt.fk_id_w = :id_w";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_w', $id_w);
        $stmt->execute();

        $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $tags;
    }
    public function getWikiById($id_w)
    {
        $tagDAO = new TagDAO();
        $query = "SELECT * FROM wiki WHERE id_w = :id_w";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_w", $id_w, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $tags = array();
            $wiki = new Wiki($result["id_w"], $result["titre"], $result["contenu"], $result["wiki_date"], $result["isArchive"], $result["img"], $result["fk_aut_email"], $result["fk_cat"]);
            $tags = $tagDAO->getTagsByWiki($result["id_w"]);
            $wiki->setTags($tags);
            return $wiki;
        } else {
            return null;
        }
    }
}