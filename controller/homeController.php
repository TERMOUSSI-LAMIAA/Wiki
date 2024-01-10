<?php
require_once 'controller/wikiController.php';


class contoller_home
{
    function getHomeController()
    {
        $wikiController=new contoller_wiki();
        $wikiController->getWikiController();
        //$recwikis

    }
  
}