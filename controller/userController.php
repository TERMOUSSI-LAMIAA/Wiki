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
                $_SESSION['role']=$logged;
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
    function logoutController(){
        if (isset($_GET['action']) && $_GET['action'] == 'logout') {
            $userDAO = new UtilisateurDAO();
            $userDAO->logout_user();
            // header("location:index.php?action=loginForm");
        }
        else{
            echo 'logout error';
        }
       
    }
   

}