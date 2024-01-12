<?php
require_once 'model/wikiDAO.php';
require_once "model/utilisateurDAO.php";
require_once 'model/categorieDAO.php';
require_once 'model/tagDAO.php';
class contoller_dashboard
{
    function getDashboardController()
    {
        session_start();
        if (isset($_SESSION['email'])) {
            $role = $_SESSION['role'];
            $wikiDAO = new WikiDAO();
            $totWikis = $wikiDAO->statsWikis();
            $userDAO = new UtilisateurDAO();
            $totAut = $userDAO->statsAuteurs($role);
            $catgDAO = new CategorieDAO();
            $totCatgs = $catgDAO->statsCatgs();
            $tagDAO = new TagDAO();
            $totTags = $tagDAO->statsTags();
            include('view/admin/dashboard.php');
        } else {
            echo 'error session';
        }

    }

}