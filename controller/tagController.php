<?php
require_once 'model/tagDAO.php';


class contoller_tag
{
    function getTagController()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === "admin") {
            $tagDAO = new TagDAO();
            $tags = $tagDAO->get_tag();
            include 'view/admin/showTags.php';
        } else {
            echo 'error session';
        }

    }

    function addTagController()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === "admin") {
            include 'view\admin\addTag.php';
        } else {
            echo 'error session';
        }
    }

    function addTagControllerAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tagDAO = new TagDAO();
            $inserted = $tagDAO->insert_tag();
            if ($inserted) {
                header('Location: index.php?action=showTag');
                exit();
            } else {
                echo 'Adding error';
            }
        }
    }
    public function updtTagController()
    {
        session_start();
        if (isset($_SESSION['email']) && $_SESSION['role'] === "admin") {
            if (isset($_GET['nom_tag'])) {
                $nom_tag = $_GET['nom_tag'];
                $tagDAO = new TagDAO();
                $tag = $tagDAO->getTagByName($nom_tag);
                include("view/admin/updtTag.php");
            }
        } else {
            echo 'error session';
        }

    }
    public function updtTagControllerAction()
    {
        try {
            $tagDAO = new TagDAO();
            $tagDAO->update_tag();
            header('Location: index.php?action=showTag');
            exit;
        } catch (Exception $e) {
            error_log('Error in updtCatgControllerAction:' . $e->getMessage(), 0);
        }

    }
    public function deleteTagControllerAction()
    {
        $nom_tag = $_GET['nom_tag'];
        $tagDAO = new TagDAO();
        $tagDAO->delete_tag($nom_tag);
        header('Location: index.php?action=showTag');
        exit;
    }
}