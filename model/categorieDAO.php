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


//     public function getBusByImmat($immat)
//     {
//         $query = "SELECT * FROM bus WHERE immat = :immat";
//         $stmt = $this->db->prepare($query);
//         $stmt->bindParam(":immat", $immat, PDO::PARAM_STR);
//         $stmt->execute();

//         // Fetch the result
//         $result = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($result) {
//             // Create a Bus object using the fetched data
//             return new Bus($result["immat"], $result["numbus"], $result["capacite"], $result["fk_idEn"]);
//         } else {
//             // Return null or handle the case where the bus with given immat is not found
//             return null;
//         }
//     }

//     public function updateBus()
//     {
//         if ($_SERVER["REQUEST_METHOD"] == "POST") {
//             // Get values from $_POST
//             $immat = $_POST["immatriculation"];
//             $numbus = $_POST["numero_bus"];
//             $capacite = $_POST["capacite"];
//             $fk_idEn = $_POST["fk_idEn"];

//             try {
//                 // Prepare the SQL statement
//                 $query = "update bus set  numbus=:numbus, capacite=:capacite, fk_idEn=:fk_idEn WHERE immat=:immat";
//                 $stmt = $this->db->prepare($query);
//                 // Bind parameters
//                 $stmt->bindParam(':immat', $immat);
//                 $stmt->bindParam(':numbus', $numbus);
//                 $stmt->bindParam(':capacite', $capacite);
//                 $stmt->bindParam(':fk_idEn', $fk_idEn);
//                 $stmt->execute();
//                 // Return true on success
//                 return true;
//             } catch (PDOException $e) {
//                 echo "Error: " . $e->getMessage();
//                 return false;
//             }
//         }
//     }
//     function deleteBus($immat)
//     {
//         try {
//             $query = "delete from bus where immat=:immat";
//             $stmt = $this->db->prepare($query);
//             $stmt->bindParam(':immat', $immat);
//             $stmt->execute();
//             return true;
//         } catch (PDOException $e) {
//             echo "Error: " . $e->getMessage();
//             return false;
//         }
//     }
}

?>