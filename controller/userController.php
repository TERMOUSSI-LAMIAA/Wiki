<?php
require_once "model/utilisateurDAO.php";



class contoller_Utilisateur
{
    function addUserControllerAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userDAO = new UtilisateurDAO();
            $inserted = $userDAO->insert_user();

            if ($inserted) {
                header('Location: index.php?action=loginForm');
                exit();
            } else {
                echo 'Adding error';
            }
        }
    }
    function addUserController()
    {
        include "view/register.php";
    }
    function formLoginUserController()
    {
        include "view/login.php";
    }
    function loginUserController()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userDAO = new UtilisateurDAO();
            $logged = $userDAO->login_user();
            // var_dump($logged);
            if ($logged) {       
                $_SESSION['email'] = $_POST['email'];
                $email = $_SESSION['email'];
                $name = $userDAO->get_userByEmail($email);
                $_SESSION['nom'] = $name;
            }
            if ($logged === "admin") {
                header('Location: index.php?action=dashboard');
                exit();
            } elseif ($logged === "auteur") {
                header('Location: index.php?action=showWikiAut');
                exit();
            } else {
                echo 'login error';
            }


        }
    }
    // public function updtBusController()
    // {
    //     if (isset($_GET['immat'])) {
    //         $immat = $_GET['immat'];
    //         $entrepriseDAO = new EntrepriseDAO();
    //         $entreprises = $entrepriseDAO->get_entreprise();
    //         $busDAO = new BusDAO();
    //         $bus = $busDAO->getBusByImmat($immat);
    //         include("Vue\admin\updtBus.php");
    //     }
    // }

    // public function updtBusControllerAction()
    // {
    //     try {
    //         $busDAO = new BusDAO();
    //         $busDAO->updateBus();
    //         header('Location: index.php?action=admin');
    //         exit;
    //     } catch (Exception $e) {
    //         error_log('Error in updtBusControllerAction: ' . $e->getMessage(), 0);
    //     }
    // }
    // public function deleteBusControllerAction()
    // {
    //     $immat = $_GET["immat"];
    //     $busDAO = new BusDAO();
    //     $busDAO->deleteBus($immat);
    //     header('Location: index.php?action=admin');
    //     exit;
    // }

}