<?php
require_once 'controller/wikiController.php';
require_once 'model/wikiDAO.php';
require_once 'controller/categorieController.php';


class contoller_home
{
    function getHomeController()
    {
        $wikiController = new contoller_wiki();
        $wikiController->getWikiController();
    }
    function searchController()
    {
        $searchVal = isset($_GET["searchVal"]) ? $_GET["searchVal"] : null;
        $results = array();
        $errors=array();
        $wikiDAO = new WikiDAO();
       
        if (!empty($searchVal)) {
            $srchWikis = $wikiDAO->searchByTitleTagCatg($searchVal);
            if (!empty($srchWikis)) {
                $results = array_merge($results, $srchWikis);
            } else {
                $errors[] = "No wikis found.";
            }
        } else {
            $errors[] = "searchVal is empty";
        }
        echo json_encode(array("data" => $results, "errors" => $errors));
    }

}