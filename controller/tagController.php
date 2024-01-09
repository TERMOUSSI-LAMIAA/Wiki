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
    // public function updtCatgController()
    // {
    //     if (isset($_GET['nom_cat'])) {
    //         $nom_cat= $_GET['nom_cat'];
    //         $catgDAO = new CategorieDAO();
    //         $catg= $catgDAO->getCatgByName($nom_cat);
    //         include("view/admin/updtCatgs.php");
    //     }
    // }
    // public function updtCatgControllerAction()
    // {
    //     try{
    //         $catgDAO = new CategorieDAO();
    //         $catgDAO->update_categorie();
    //         header('Location: index.php?action=showCat');
    //         exit;
    //     }
    //     catch (Exception $e) {
    //         error_log('Error in updtCatgControllerAction:' . $e->getMessage(), 0);
    //     }

    // }
    // public function deleteCatgControllerAction()
    // {
    //     $nom_cat= $_GET['nom_cat'];
    //     $catgDAO = new CategorieDAO();
    //     $catgDAO->delete_categorie($nom_cat);
    //     header('Location: index.php?action=showCat');
    //     exit;
    // }
}