<?php
include 'model/wikiDAO.php';


class contoller_wiki
{
    function getWikiController()
    {
        $wikiDAO = new WikiDAO();
        $wikis = $wikiDAO->get_wiki();
        include 'view/admin/archiveWiki.php';
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
    // function addTagController()
    // {
    //     include 'view\admin\addTag.php';
    // }

    // function addTagControllerAction()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $tagDAO = new TagDAO();
    //         $inserted = $tagDAO->insert_tag();
    //         if ($inserted) {
    //             header('Location: index.php?action=showTag');
    //             exit();
    //         } else {
    //             echo 'Adding error';
    //         }
    //     }
    // }
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