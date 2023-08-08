<?php

namespace models;

use connexion\DataBase;

class Admin extends DataBase
{
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function createAdmin()
    {
        $pseudo = "oceane";
        $mail = "oceane@roux.fr";
        $hash = password_hash("", PASSWORD_DEFAULT);
        
        // 2- préparer la requete SQL 
        $query = $this -> database -> prepare('
                                        INSERT INTO `admin`(`pseudo`, `mail`, `password`)
                                        VALUES(
                                            ?,
                                            ?,
                                            ?)
                                ');
        // 3- éxécuter la requete SQL 
        $test = $query -> execute(array($pseudo, $mail, $hash));

        var_dump($test);    
    }
    
    public function getAdminByEmail($mail){
        
        $query = $this -> database -> prepare('
                                        SELECT `id_admin`, `pseudo`, `mail`, `password`
                                        FROM admin
                                        WHERE mail = ?
                                ');
        $query -> execute([$mail]);
        
        $admin = $query -> fetch();
        
        return $admin;
    }
}   
