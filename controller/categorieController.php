<?php
include 'model/categorieDAO.php';


class contoller_categorie
{
    function getCatgController()
    {
        $catgDAO = new CategorieDAO();
        $catgs = $catgDAO->get_categorie();
        include 'view/admin/showCatgs.php';
    }

    function addCatgController(){
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
}