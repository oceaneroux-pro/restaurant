<?php
namespace controllers;

use models\Meal;
use models\Order;
use controllers\SecurityController;

class OrderController extends SecurityController
{
    private Order $order;
    
    public function __construct()
    {
        $this -> meal = new Meal();
        $this -> order = new Order();
    }
    
    public function order()
    {
        if($this-> is_connect())
        {
            $meals = $this -> meal -> getMeals();
            $template = "order/order";
            require "views/layout.phtml";
        }
        else{
            header("location:index.php?action=connexion");
            exit();
        }
    }
    
    public function cmdAjax()
    {
        if(array_key_exists('id',$_GET))
        {
            $meal = $this -> meal -> getMealById($_GET['id']);
            
            echo json_encode($meal);
        }
            
        else if(array_key_exists('commande',$_GET) && array_key_exists('total',$_GET))
        {
            $commandeJSON = $_GET['commande'];
            $commande = json_decode($commandeJSON, true);
            $prixTotal = $_GET['total'];
            $id_client = $_SESSION['client']['id_client'];
            $date = date("Y-m-d H:i:s");
                    
            $id_commande = $this -> order -> addOrder($id_client,$date,$prixTotal);
          
          foreach($commande as $cmd)
          {
              $test = $this -> order -> addDetailsOrder($id_commande,$cmd['produit']['id_produit'],$cmd['quantite'],$cmd['produit']['prix_unité']);
          }
          echo $test;
        } 
    }
    
    public function listOrders():void
    {
        $orders = $this -> order -> getOrders();
        $template = "admin/orderList";
        require "views/layout.phtml";
    }
    
    public function afficheOrderDetails()
    {
        
        if(array_key_exists('id',$_GET) && is_numeric($_GET['id']))
        {
            $id_commande = $_GET['id'];
            
            $orderdetails = $this -> order -> afficheOrderDetails($id_commande);
            
            $template = "views/admin/orderDetails";
            require "views/layout.phtml"; 
        }
    }
    
    public function deleteOrder()
    {
        if($this -> isAdmin())
        {
            if(array_key_exists('id',$_GET) && is_numeric($_GET['id']))
            {
                $id_commande = $_GET['id'];
                $order = $this -> order -> getOrderById($id_commande);
                $deleteOrder = $this -> order -> deleteOrder($id_commande);
                
                if($deleteOrder)
                {
                    $message = "La commande a bien été supprimée";
                    header("location:index.php?action=listOrders&message=$message");
                    exit();
                }
            }
        }
        else
            {
                header("location:index.php");
                exit();
            }   
                
    }
}