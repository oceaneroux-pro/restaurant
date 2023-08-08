<?php
session_start();

// les namespace 
use connexion\DataBase;
use controllers\MealController;
use controllers\UserController;
use controllers\BookingController;
use controllers\OrderController;
use controllers\AdminController;

//autoload
function chargerClasse($classe)
{
    $classe = str_replace('\\','/',$classe);      
    require $classe.'.php'; 
}

spl_autoload_register('chargerClasse'); //fin Autoload

// appel aux controllers 
$mealController = new MealController();
$userController = new UserController();
$bookingController = new BookingController();
$orderController = new OrderController();
$adminController = new AdminController();

if(array_key_exists("action",$_GET))
{
    switch($_GET['action'])
    {
        case "createAccount" :
            $userController-> createAccount();
            break;
        case "connexion" :
            $userController-> connexion();
            break;
        case "deconnexion" : 
            $userController -> deconnexion();
            break;
        case "booking" : 
            $bookingController -> booking();
        break;
        case "order" :
            $orderController-> order();
            break;
        case "cmdAjax" : 
             $orderController-> cmdAjax();
            break;
        case "admin":
            $adminController -> admin();
            break;
        case"deconnexionAdmin":
            $adminController -> deconnexionAdmin();
            break;
        case"addMenu":
            $mealController -> addMenus();
            break;
        case"modifMenu":
            $mealController -> modifMenus();
            break;  
        case "deleteMenu":
            $mealController->deleteMenu();
            break;
        case "bookingListe":
            $bookingController-> bookingList();
            break;
        case  "deleteBooking":
            $bookingController-> deleteBooking();
            break;
        case "listOrders":
            $orderController-> listOrders();
            break;
        case "orderDetails":
            $orderController-> afficheOrderDetails();
            break;
        case  "deleteOrder":
            $orderController-> deleteOrder();
            break;
        case "compteUser":
            $userController-> afficheUserInfo();
            break;
        case "modifyProfile":                  
            $userController-> modifyProfile(); 
            break;
    }
}
else
{
    $mealController -> listMeals();// pour afficher la page d'accueil 
}