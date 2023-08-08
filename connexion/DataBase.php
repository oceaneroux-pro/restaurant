<?php
namespace connexion;

class DataBase
{
    // attributs
    private const SERVER = "";
    private const DB = "";
    private const USER = "";
    private const MDP = "";
    private $connexion;
    // methodes --> getter et setter 
    
    function getConnexion(): ?\PDO
    {
        try
        { // lance la connexion à la BDD 
            $this -> connexion = new \PDO("mysql:host=".self::SERVER.";dbname=".self::DB.";charset=utf8",self::USER,self::MDP);
        }
        // si tu trouves des erreurs 
        catch(Exception $message)
        {
            die('Message erreur connexion BDD'.$message->getMessage());
        }
        
        return $this -> connexion;
    }
}

// // tester la connexion 
// $database = new DataBase();
// var_dump($database -> getConnexion());