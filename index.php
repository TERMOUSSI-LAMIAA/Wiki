<?php
include "controller/userController.php";
include "controller/dashboardController.php";
include "controller/categorieController.php";

$controllerUser = new contoller_Utilisateur();
$controllerDashboard = new contoller_dashboard();
$controllerCatg = new contoller_categorie();


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
        // case 'deleteRouteShow':
        //     $controllerRoute->deleteRouteControllerAction();
        //     break;
        // case 'showHoraire':
        //     $controllerHoraire->getHoraireController();
        //     break;
        // case 'addHoraireform':
        //     $controllerHoraire->addHoraireController();
        //     break;
        // case 'addHoraire':
        //     $controllerHoraire->addHoraireControllerAction();
        //     break;
        // case 'updateHorShow':
        //     $controllerHoraire->updtHorController();
        //     break;
        // case 'deleteHor':
        //     $controllerHoraire->deleteHorControllerAction();


        // case 'homePage':
        //     $controllerHome->getVilleHomeController();
        //     break;
        // case 'mainSearch':
        //     $controllerHome->getSearchedHoraireController();

        //     break;
        // case 'entrepFilter':
        //     $controllerDetail->filterController();
        //     break;
        // case 'priceFilter':
        //     $controllerDetail->filterController();
        //     break;
        // // case 'entrepFilter':
        // case 'horaireFilter':
        //     $controllerDetail->filterController();
        //     break;
    }

} else {
    $controllerUser->addUserController();
}
?>