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
        
    }

}