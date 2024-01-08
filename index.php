<?php
include "controller/userController.php";
include "controller/dashboardController.php";

$controllerUser = new contoller_Utilisateur();
$controllerDashboard = new contoller_dashboard();



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
        // case 'deleteBus':
        //     $controllerBus->deleteBusControllerAction();
        //     break;
        // case 'showRoute':
        //     $controllerRoute->getRouteController();
        //     break;
        // case 'addRouteform':
        //     $controllerRoute->addRouteController();
        //     break;
        // case 'addRoute':
        //     $controllerRoute->addRouteControllerAction();
        //     break;
        // case 'updateRouteShow':
        //     $controllerRoute->updtRouteController();
        //     break;
        // case 'updtRoute':
        //     $controllerRoute->updtRouteControllerAction();
        //     break;
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