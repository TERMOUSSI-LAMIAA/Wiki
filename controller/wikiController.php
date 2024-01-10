<?php
require_once 'model/wikiDAO.php';
require_once 'model/categorieDAO.php';
require_once 'model/utilisateurDAO.php';
require_once 'controller/userController.php';
require_once 'model/tagDAO.php';


class contoller_wiki
{
    function getWikiController()
    {
        $wikiDAO = new WikiDAO();
        $wikis = $wikiDAO->get_wiki();
        include 'view/admin/archiveWiki.php';
    }
    function getWikiAutController()
    { ///!!!!
        session_start();
        $email = $_SESSION['email'];
        $wikiDAO = new WikiDAO();
        $wikis = $wikiDAO->get_wiki($email);
        include 'view/auteur/showWiki.php';
    }

    function archiveWikiController()
    {
        if (isset($_GET['id_w'])) {
            $id_w = $_GET['id_w'];
            try {
                $wikiDAO = new WikiDAO();
                $wikiDAO->archive_wiki($id_w);
                header('Location: index.php?action=showWiki');
                exit;
            } catch (Exception $e) {
                error_log('Error in archiveWikiController:' . $e->getMessage(), 0);
            }
        }
    }
    function addWikiController()
    {
        $catgDAO = new CategorieDAO();
        $catgs = $catgDAO->get_categorie();
        $auteursDAO = new UtilisateurDAO();
        $auteurs = $auteursDAO->get_utilisateur('auteur');
        $tagsDAO = new TagDAO();
        $tags = $tagsDAO->get_tag();
        include 'view\auteur\addWiki.php';
    }

    function addWikiControllerAction()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_SESSION['email'];
            $wikiDAO = new WikiDAO();
            $inserted = $wikiDAO->insert_wiki($email);
            if ($inserted) {
                header('Location: index.php?action=showWikiAut');
                exit();
            } else {
                echo 'Adding error';
            }
        }
    }
    // public function updtTagController()
    // {
    //     if (isset($_GET['nom_tag'])) {
    //         $nom_tag = $_GET['nom_tag'];
    //         $tagDAO = new TagDAO();
    //         $tag = $tagDAO->getTagByName($nom_tag);
    //         include("view/admin/updtTag.php");
    //     }
    // }
    // public function updtTagControllerAction()
    // {
    //     try {
    //         $tagDAO = new TagDAO();
    //         $tagDAO->update_tag();
    //         header('Location: index.php?action=showTag');
    //         exit;
    //     } catch (Exception $e) {
    //         error_log('Error in updtCatgControllerAction:' . $e->getMessage(), 0);
    //     }

    // }
    // public function deleteTagControllerAction()
    // {
    //     $nom_tag = $_GET['nom_tag'];
    //     $tagDAO = new TagDAO();
    //     $tagDAO->delete_tag($nom_tag);
    //     header('Location: index.php?action=showTag');
    //     exit;
    // }
}