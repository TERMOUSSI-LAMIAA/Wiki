<?php
require_once 'model/categorieDAO.php';


class contoller_categorie
{
    function getCatgController()
    {
        $catgDAO = new CategorieDAO();
        $catgs = $catgDAO->get_categorie();
        include 'view/admin/showCatgs.php';
    }

    function addCatgController()
    {
        include 'view\admin\addCatg.php';
    }

    function addCatgControllerAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $catgDAO = new CategorieDAO();
            $inserted = $catgDAO->insert_catg();
            if ($inserted) {
                header('Location: index.php?action=showCat');
                exit();
            } else {
                echo 'Adding error';
            }
        }
    }
    public function updtCatgController()
    {
        if (isset($_GET['nom_cat'])) {
            $nom_cat = $_GET['nom_cat'];
            $catgDAO = new CategorieDAO();
            $catg = $catgDAO->getCatgByName($nom_cat);
            include("view/admin/updtCatgs.php");
        }
    }
    public function updtCatgControllerAction()
    {
        try {
            $catgDAO = new CategorieDAO();
            $catgDAO->update_categorie();
            header('Location: index.php?action=showCat');
            exit;
        } catch (Exception $e) {
            error_log('Error in updtCatgControllerAction:' . $e->getMessage(), 0);
        }

    }
    public function deleteCatgControllerAction()
    {
        $nom_cat = $_GET['nom_cat'];
        $catgDAO = new CategorieDAO();
        $catgDAO->delete_categorie($nom_cat);
        header('Location: index.php?action=showCat');
        exit;
    }
}