<?php
require_once 'controller/wikiController.php';
require_once 'model/wikiDAO.php';


class contoller_home
{
    function getHomeController()
    {

        $wikiController = new contoller_wiki();
        $wikiController->getWikiController();

    }

}