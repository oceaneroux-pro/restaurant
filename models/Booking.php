<?php

namespace models;

use connexion\DataBase;

class Booking extends DataBase{
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function insertResa($id_client, $date, $heure, $couverts): ?bool
    {
        $booking = null;
        
        $query = $this->database->prepare('
                                            INSERT INTO `reservations`(
                                                `id_client`,
                                                `date`,
                                                `heure`,
                                                `nb_couverts`
                                            )
                                            VALUES(
                                                :id_client,
                                                :date,
                                                :heure,
                                                :nb_couverts
                                            )
                                                ');
    
        $test = $query->execute(array(
        
              'id_client' => $id_client,
              'date' => $date,
              'heure' => $heure,
              'nb_couverts' => $couverts
              ));
        
        return $test; 
        
    }
    
    public function getBookingList(): ?array
    {
        $bookList = null;
        $query = $this -> database ->prepare('
                                               SELECT
                                                    `id_reservation`,
                                                    `reservations`.`nb_couverts`,
                                                    `reservations`.`date`,
                                                    `reservations`.`heure`,
                                                    `clients`.`nom`,
                                                    `clients`.`prenom`
                                                FROM
                                                    `reservations`
                                                INNER JOIN `clients`
                                                ON
                                                    `reservations`.`id_client` = `clients`.`id_client`
                                        ');
                                        
        $query -> execute();
        $bookings = $query -> fetchAll();
        
        return $bookings; 
                                    
    }
    
    public function getBookingById($getBookingById) 
    {
        $query = $this -> database -> prepare('
                                                    SELECT
                                                    `id_reservation`,
                                                    `reservations`.`nb_couverts`,
                                                    `reservations`.`date`,
                                                    `reservations`.`heure`,
                                                    `clients`.`nom`,
                                                    `clients`.`prenom`
                                                FROM
                                                    `reservations`
                                                INNER JOIN `clients`
                                                ON
                                                    `reservations`.`id_reservation` = `clients`.`id_client`;
                                                WHERE 
                                                    `id_reservation` = ?
                                                    ');
        
        $query -> execute([$getBookingById]);
        
        $getBooking = $query -> fetch();
        
        return $getBooking; 
    }
    
    
    public function deleteBooking($id_reservation)
    {
        
        $query = $this -> database->prepare('
                                                DELETE
                                                FROM
                                                    `reservations`
                                                WHERE
                                                    `id_reservation` = ?
                                           ');
    
        $test = $query -> execute([$id_reservation]);
        return $test;
    }
}
