<?php
namespace controllers;

use models\Booking;
use controllers\SecurityController;

class BookingController extends SecurityController{
    
    private Booking $booking;
    
    public function __construct()
    {
        $this -> booking = new Booking();
    }
    
    public function booking(){
        
        if($this-> is_connect())
        {
            if(isset($_POST['date']) && !empty($_POST['date'])
            && isset($_POST['heure']) && !empty($_POST['heure'])
            && isset($_POST['couverts']) && !empty($_POST['couverts'])) // si formulaire envoyé
            {
                $date = htmlspecialchars($_POST['date']); // récup date
                $heure = htmlspecialchars($_POST['heure']); // récup heure
                $couverts = htmlspecialchars($_POST['couverts']); // récup nb couverts
                
                $id_client = $_SESSION['client']['id_client'] ;
                
                if($id_client) // si id_client = true (car type bool)
                { 
                    $test = $this -> booking -> insertResa($id_client, $date, $heure, $couverts);
                    var_dump($test);
                    
                    if($test)
                    {
                        $message = "Votre réservation à bien été prise en compte le ".$date." à ".$heure;
                        header("location:index.php?action=booking&message=$message");
                    }
                    else
                    {
                        $message = "une erreur est survenue";
                    }
                }
            }
            
            $template = "booking/booking";
            require "views/layout.phtml";
        }
        else{
            header("location:index.php?action=connexion");
            exit();
        }
    }
    
    public function bookingList():void
    {
       // récupérer les repas 
        $bookings = $this -> booking -> getBookingList();
        // transmettre au template pour les afficher 
        $template = "admin/listeBooking";
        // à ne pas oublier de passer par le layout
        require "views/layout.phtml"; 
    }
    
    public function deleteBooking()
    {
        if($this -> isAdmin())
        {
            if(array_key_exists('id',$_GET) && is_numeric($_GET['id']))
            {
                $id_reservation = $_GET['id'];
                $bookings = $this -> booking -> getBookingById($id_reservation);
                $deleteBooking = $this -> booking -> deleteBooking($id_reservation);
                
                if($deleteBooking)
                {
                    $message = "La reservation à bien été supprimé";
                    header("location:index.php?action=bookingListe&message=$message");//'message=$message' transmet la variable $message à la nouvelle page(action=modifMenu).
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