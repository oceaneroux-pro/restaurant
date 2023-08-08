<?php

namespace models;

use connexion\DataBase;

class User extends DataBase
{
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function addUser($nom, $prenom, $anniversaire, $adresse, $codePostal, $pays, $tel, $mail, $mdp): ?bool
    {
        $user = null;
        
        $query = $this->database->prepare('
                                            INSERT INTO `clients`(
                                                `nom`,
                                                `prenom`,
                                                `anniversaire`,
                                                `adresse`,
                                                `code_postal`,
                                                `pays`,
                                                `mail`,
                                                `mdp`,
                                                `tel`
                                            )
                                            VALUES(
                                                :nom,
                                                :prenom,
                                                :anniversaire,
                                                :adresse,
                                                :code_postal,
                                                :pays,
                                                :mail,
                                                :mdp,
                                                :tel
                                            )
                                                ');
    
        $test = $query->execute(array(
        
               'nom' => $nom,
               'prenom' => $prenom,
               'anniversaire' => $anniversaire,
               'adresse' => $adresse,
               'code_postal' => $codePostal,
               'pays' => $pays,
               'mail' => $mail,
               'mdp' => $mdp,
               'tel' => $tel
               ));
        
        return $test; 
    }
    
    
    
    public function getUserByEmail($mail){
        
        $query = $this -> database -> prepare('
                                        SELECT `mail`, `mdp`,`id_client`,`nom`,`prenom`
                                        FROM clients
                                        WHERE mail = ?
                                ');
        $query -> execute([$mail]);
        
        $user = $query -> fetch();
        
        return $user;
    }
    
    public function afficheUserInfo($id)
    {
        $query = $this -> database -> prepare('
                                                SELECT
                                                    `id_client`,
                                                    `nom`,
                                                    `prenom`,
                                                    `anniversaire`,
                                                    `adresse`,
                                                    `code_postal`,
                                                    `pays`,
                                                    `mail`,
                                                    `mdp`,
                                                    `tel`
                                                FROM
                                                    `clients`
                                                WHERE
                                                    id_client = ?
                                            ');
        $query -> execute([$id]);
        
        $userInfo = $query -> fetch();
        
        return $userInfo; 
    }
    
    
    public function changeProfile($nom,$prenom,$anniversaire,$adresse,$pays,$codePostal,$tel,$mail,$id_client)
    {
        $query = $this -> database->prepare('
                                                    UPDATE
                                                        `clients`
                                                    SET
                                                        `nom` = :nom,
                                                        `prenom` = :prenom,
                                                        `anniversaire` = :anniversaire,
                                                        `adresse` = :adresse,
                                                        `pays` = :pays,
                                                        `code_postal` = :code_postal,
                                                        `tel` = :tel,
                                                        `mail` = :mail
                                                    WHERE
                                                        id_client = :id_client                                            
                                                        ');
        $test = $query->execute(array(
              'nom' => $nom,
              'prenom' => $prenom,
              'anniversaire'=>$anniversaire,
              'adresse'=>$adresse,
              'pays'=>$pays,
              'code_postal' => $codePostal,
              'tel'=>$tel,
              'mail'=>$mail,
              'id_client'=>$id_client
              ));
        
        return $test;
    }
}




