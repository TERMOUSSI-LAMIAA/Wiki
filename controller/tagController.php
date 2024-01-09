<?php
include 'model/tagDAO.php';


class contoller_tag
{
    function getTagController()
    {
        $tagDAO = new TagDAO();
        $tags = $tagDAO->get_tag();
        include 'view/admin/showTags.php';
    }

    function addTagController()
    {
        include 'view\admin\addTag.php';
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
        if (isset($_GET['nom_tag'])) {
            $nom_tag = $_GET['nom_tag'];
            $tagDAO = new TagDAO();
            $tag = $tagDAO->getTagByName($nom_tag);
            include("view/admin/updtTag.php");
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