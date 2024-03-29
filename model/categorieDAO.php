<?php
require_once 'connection/connexion.php';
require_once 'model/categorieModel.php';
class CategorieDAO
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_categorie($action="")
    {
        $query = "SELECT * FROM categorie";
        if ($action === 'home') {
            $query .= " order by cat_date desc limit 5";
        }
        $stmt = $this->db->query($query);
        $stmt->execute();
        $catgData = $stmt->fetchAll();
        $catgs = array();
        foreach ($catgData as $B) {
            $catgs[] = new Categorie($B["nom_cat"], $B["cat_date"]);
        }
        return $catgs;
    }
    public function insert_catg()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom_cat = $_POST["nom_cat"];
            $cat_date = $_POST["cat_date"];
            try {
                $query = "INSERT INTO categorie (nom_cat, cat_date) VALUES (:nom_cat, :cat_date)";
                $stmt = $this->db->prepare($query);

                $stmt->bindParam(':nom_cat', $nom_cat);
                $stmt->bindParam(':cat_date', $cat_date);
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
    public function getCatgByName($nom_cat)
    {
        $query = "SELECT * FROM categorie WHERE nom_cat = :nom_cat";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":nom_cat", $nom_cat, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Categorie($result["nom_cat"], $result["cat_date"]);
        } else {
            return null;
        }

    }

    public function update_categorie()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_nom_cat = $_POST["new_nom_cat"];
            $old_nom_cat = $_POST["old_nom_cat"];
            $cat_date = $_POST["cat_date"];
            try {
                $query = "update categorie set nom_cat=:new_nom_cat ,cat_date=:cat_date where nom_cat=:old_nom_cat";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':new_nom_cat', $new_nom_cat);
                $stmt->bindParam(':old_nom_cat', $old_nom_cat);
                $stmt->bindParam(':cat_date', $cat_date);
                $stmt->execute();

                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
    }
    public function statsCatgs(){
        try {
            $query = "select count(nom_cat) as total_catgs from categorie";
            $stmt = $this->db->query($query);
            $catgsData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $catgsData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function delete_categorie($nom_cat)
    {
        try {
            $query = "delete from categorie where nom_cat=:nom_cat";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nom_cat', $nom_cat);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

?>