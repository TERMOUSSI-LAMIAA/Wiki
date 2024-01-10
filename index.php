<?php
include "controller/userController.php";
include "controller/dashboardController.php";
include "controller/categorieController.php";
include "controller/tagController.php";
include "controller/wikiController.php";
include "controller/homeController.php";

$controllerUser = new contoller_Utilisateur();
$controllerDashboard = new contoller_dashboard();
$controllerCatg = new contoller_categorie();
$controllerTag = new contoller_tag();
$controllerWiki = new contoller_wiki();
$controllerHome = new contoller_home();


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'admin':
            break;
        case 'addUser':
            $controllerUser->addUserControllerAction();
            break;
        case 'loginForm':
            $controllerUser->formLoginUserController();
            break;
        case 'login':
            $controllerUser->loginUserController();
            break;
        case 'dashboard':
            $controllerDashboard->getDashboardController();
            break;
        case 'showCat':
            $controllerCatg->getCatgController();
            break;
        case 'addCatForm':
            $controllerCatg->addCatgController();
            break;
        case 'addCat':
            $controllerCatg->addCatgControllerAction();
            break;
        case 'updateCatShow':
            $controllerCatg->updtCatgController();
            break;
        case 'updtCat':
            $controllerCatg->updtCatgControllerAction();
            break;
        case 'deleteCat':
            $controllerCatg->deleteCatgControllerAction();
            break;
        case 'showTag':
            $controllerTag->getTagController();
            break;
        case 'addTagForm':
            $controllerTag->addTagController();
            break;
        case 'addTag':
            $controllerTag->addTagControllerAction();
            break;
        case 'deleteTag':
            $controllerTag->deleteTagControllerAction();
            break;
        case 'updateTagShow':
            $controllerTag->updtTagController();
            break;
        case 'updtTag':
            $controllerTag->updtTagControllerAction();
            break;
        case 'archivWiki':
            $controllerWiki->archiveWikiController();
            break;
        case 'showWiki':
            $controllerWiki->getWikiController();
            break;
        case 'showWikiAut':
            $controllerWiki->getWikiAutController();
            break;
        case 'addWikiForm':
            $controllerWiki->addWikiController();
            break;
        case 'addWiki':
            $controllerWiki->addWikiControllerAction();
            break;
        case 'logout':
            $controllerUser->logoutController();
            break;
        case 'home':
            $controllerHome->getHomeController();
            break;
    }

} else {
    $controllerHome->getHomeController();
}
?>