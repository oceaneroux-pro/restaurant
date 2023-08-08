<?php
namespace models;

use connexion\DataBase;

class Meal extends DataBase
{
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function getMeals(): ?array
    {
        $meals = null;
        // 2- préparer la requete SQL 
        $query = $this -> database -> prepare('
                                                SELECT
                                                    id_produit,
                                                    `titre`,
                                                    `details`,
                                                    `prix_unité`,
                                                    `image`
                                                FROM
                                                    `produits`  
                                        ');// la requete SQL 
        // 3- éxécuter la requete SQL 
        $query -> execute();
        // 4- récupérer les données envoyé par la requete 
        $meals = $query -> fetchAll();// fetch --> si on a qu'une seule ligne à récupérer 
        
        return $meals; 
    }
    
    public function getMealById($mealById) :array
    {
        $query = $this -> database -> prepare('
                                               SELECT
                                                    `id_produit`,
                                                    `titre`,
                                                    `details`,
                                                    `prix_unité`,
                                                    `image`
                                                FROM
                                                    `produits`
                                                WHERE
                                                    `id_produit` = ?
                                        ');
                                        
        $query -> execute([$mealById]);
        
        $mealById = $query -> fetch();
        
        return $mealById; 
    }
    
    public function addMenu($titre,$details,$prix_unite,$image)
    {
       $addMenu = null;
       $query = $this -> database -> prepare(' 
                                                    INSERT INTO `produits`(
                                                                `titre`,
                                                                `details`,
                                                                `prix_unité`,
                                                                `image`
                                                            )
                                                            VALUES(
                                                                :titre,
                                                                :details,
                                                                :prix_unite,
                                                                :image
                                                           )');
        $addMenu = $query->execute(array(
              
               'titre' => $titre,
               'details' => $details,
               'prix_unite' => $prix_unite,
               'image' => $image
               ));   
               
        return $addMenu;
    }
    
    public function modifMenu($titre,$details,$prix_unite,$image,$id_produit)
    {
        $query = $this -> database->prepare('
                                                    UPDATE
                                                        `produits`
                                                    SET
                                                        `titre` = :titre,
                                                        `details` = :details,
                                                        `prix_unité` = :prix_unite,
                                                        `image` = :image
                                                    WHERE
                                                         `id_produit`= :id_produit                                              
                                                        ');
    
        $test = $query->execute(array(
        
              'titre' => $titre,
              'details' => $details,
              'prix_unite' => $prix_unite,
              'image' => $image,
              'id_produit' => $id_produit
              ));
              
        return $test;
    }
    
    public function deleteMenu($id_produit)
    {
        
        $query = $this -> database->prepare('
                                                DELETE
                                                FROM
                                                    `produits`
                                                WHERE
                                                    `id_produit` = ?
                                          ');
    
        $test = $query -> execute([$id_produit]);
        return $test;
    }
}