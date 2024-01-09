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

    public function get_categorie()
    {
        $query = "SELECT * FROM categorie";
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
            $nom_cat = $_POST["nom_cat"];
            $cat_date = $_POST["cat_date"];
            try {
                $query = "update categorie set cat_date=:cat_date where nom_cat=:nom_cat";
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
    }
}

?>