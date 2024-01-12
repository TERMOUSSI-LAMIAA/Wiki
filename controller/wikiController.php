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
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === "admin") {
            $action = isset($_GET['action']) ? $_GET['action'] : 'home';
            $wikiDAO = new WikiDAO();
            $wikis = $wikiDAO->get_wiki();
            $recwikis = $wikiDAO->get_wiki(null, $action);
            if ($action === 'showWiki') {
                include 'view/admin/archiveWiki.php';
            } elseif ($action === 'home') {
                $catgDAO = new CategorieDAO();
                $reccatgs = $catgDAO->get_categorie($action);
                include 'view/home.php';
            } elseif ($action === 'detailWiki') {
                if (isset($_GET['id_w'])) {
                    $id_w = $_GET['id_w'];
                    $wiki = $wikiDAO->get_wikiByID($id_w);
                    if ($wiki !== null) {
                        include 'view/details.php';
                    } else {
                        echo 'Wiki not found';
                    }
                }
            } else {
                echo 'no action found';
            }
        } else {
            echo 'error session';
        }

    }
    function getWikiAutController()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === "auteur") {
            $email = $_SESSION['email'];
            $wikiDAO = new WikiDAO();
            $wikis = $wikiDAO->get_wiki($email);
            include 'view/auteur/showWiki.php';
        } else {
            echo 'error session';
        }

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
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === "auteur") {
            $catgDAO = new CategorieDAO();
            $catgs = $catgDAO->get_categorie();
            $auteursDAO = new UtilisateurDAO();
            $auteurs = $auteursDAO->get_utilisateur('auteur');
            $tagsDAO = new TagDAO();
            $tags = $tagsDAO->get_tag();
            include 'view\auteur\addWiki.php';
        } else {
            echo 'error session';
        }

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
    public function updtWikiController()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === "auteur") {
            if (isset($_GET['id_w'])) {
                $id_w = $_GET['id_w'];
                $wikiDAO = new WikiDAO();
                $wiki = $wikiDAO->getWikiById($id_w);
                $catgDAO = new CategorieDAO();
                $catgs = $catgDAO->get_categorie();
                $tagDAO = new TagDAO();
                $tags = $tagDAO->get_tag();
                $selectedTags = $tagDAO->getTagsByWiki($id_w);
                include("view/auteur/updateWiki.php");
            }
        } else {
            echo 'error session';
        }

    }
    public function updtWikiControllerAction()
    {
        session_start();
        if (isset($_GET['id_w'])) {
            $id_w = $_GET['id_w'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = $_SESSION['email'];
                try {
                    $wikiDAO = new WikiDAO();
                    $updated = $wikiDAO->updt_wiki($id_w, $email);
                    if ($updated) {
                        header('Location: index.php?action=showWikiAut');
                        exit();
                    } else {
                        echo 'updating error';
                    }
                } catch (Exception $e) {
                    error_log('Error in updtWikiControllerAction:' . $e->getMessage(), 0);
                }
            }
        } else {
            echo 'id not found';
        }
    }
    public function deleteWikiController()
    {
        $id_w = $_GET['id_w'];
        $wikiDAO = new WikiDAO();
        $wikiDAO->delete_wiki($id_w);
        header('Location: index.php?action=showWikiAut');
        exit;
    }
}