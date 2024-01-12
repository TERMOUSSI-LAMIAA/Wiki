<?php
require_once 'connection/connexion.php';
require_once 'model/utilisateurModel.php';
class UtilisateurDAO
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_utilisateur($role = "")
    {
        $query = "SELECT * FROM utilisateur";
        if ($role !== null) {
            $query .= " WHERE role = :role";
        }

        $stmt = $this->db->prepare($query);

        if ($role !== null) {
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        }
        $stmt->execute();
        $userData = $stmt->fetchAll();
        $users = array();
        foreach ($userData as $B) {
            $users[] = new Utilisateur($B["email"], $B["nom"], $B["pswd"], $B["role"]);
        }
        return $users;
    }
    public function get_userByEmail($email)
    {
        try {
            $query = "SELECT nom FROM utilisateur WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                // return $result['nom'];
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return null;
        }
    }
    public function insert_user()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $nom = $_POST["nom"];
            $pswd = $_POST["pswd"];
            try {
                $query = "INSERT INTO utilisateur (email, nom, pswd) VALUES (:email, :nom, :pswd)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':pswd', $pswd);
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
    public function login_user()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $password = $_POST["pswd"];
            try {
                $query = "SELECT email, pswd ,role FROM utilisateur WHERE email = :email";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    // if (password_verify($password, $user['pswd'])) {
                    if ($password === $user['pswd']) {
                        // if ($user['role'] === 'admin') {
                        //     return true;
                        // } else {
                        //     return false;
                        // }
                        return $user['role'];
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
        return false;
    }
    public function statsAuteurs($role){
        try {
            $query = "select count(email) as total_auteur from utilisateur where role=:role";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            $AutData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $AutData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function logout_user()
    {
        session_start();

        session_unset();

        session_destroy();
        exit();
    }

}