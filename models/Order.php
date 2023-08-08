<?php
namespace models;

use connexion\DataBase;

class Order extends DataBase
{
    private $database;
    
    public function __construct()
    {
        $this -> database = $this -> getConnexion();
    }
    
    public function addOrder($id_client,$date,$prixTotal): ?int
    {
        $order = null;
        
        $query = $this->database->prepare('
                                            INSERT INTO `commandes`(
                                                `id_client`,
                                                `date_commande`,
                                                `total`
                                            )
                                            VALUES(
                                                :id_client,
                                                :date_commande,
                                                :total
                                            )
                                                ');
    
        $test = $query->execute(array(
        
               'id_client' => $id_client,
               'date_commande' => $date,
               'total' => $prixTotal,
               ));
        
        $dernier_id = $this -> database -> lastInsertId();
        
        return $dernier_id; 
    }
    
    public function addDetailsOrder($id_commande,$id_produit,$quantity,$sousTotal): ?bool
    {
       $order = null;
        // 2- préparer la requete SQL 
        $query = $this -> database -> prepare('
                                                INSERT INTO `details_commandes`(
                                                    `id_commande`,
                                                    `id_produit`,
                                                    `quantite`,
                                                    `sous_total`
                                                )
                                                VALUES(
                                                    :id_commande,
                                                    :id_produit,
                                                    :quantite,
                                                    :sous_total
                                                        )');// la requete SQL 
                                                    
                                
         $test = $query->execute(array(
    
               'id_commande' => $id_commande,
               'id_produit' => $id_produit,
               'quantite' => $quantity,
               'sous_total' => $sousTotal
               ));
               
        return $test;  
    }
    
    public function getOrders(): ?array
    {
        $orders = null;
        $query = $this -> database -> prepare('
                                                SELECT
                                                    `id_commande`,
                                                    `date_commande`,
                                                    `total`,
                                                    `nom`,
                                                    `prenom`
                                                FROM
                                                    `commandes`
                                                INNER JOIN clients 
                                                ON commandes.id_client = clients.`id_client`;
                                        ');

        $query -> execute();
        
        $orders = $query -> fetchAll();
        
        return $orders; 
    }
    
    
    public function getOrderById($getorder) 
    {
        
        // 2- préparer la requete SQL 
        $query = $this -> database -> prepare('
                                                SELECT
                                                    `id_commande`,
                                                    `id_client`,
                                                    `date_commande`,
                                                    `total`
                                                FROM
                                                    `commandes`
                                                WHERE
                                                    `id_commande`=?
                                                    ');// la requete SQL 
        // 3- éxécuter la requete SQL 
        $query -> execute([$getorder]);
        // 4- récupérer les données envoyé par la requete 
        $order = $query -> fetch();
        
        return $order; 
    }
    
    public function afficheOrderDetails($commande)
    {
        $showOrderDetails = null;
        // 2- préparer la requete SQL 
        $query = $this -> database -> prepare('
                                                SELECT
                                                    details_commandes.`id_commande`,
                                                    details_commandes.`id_produit`,
                                                    `quantite`,
                                                    `sous_total`,
                                                    quantite*sous_total as TotalPanier,
                                                    nom,
                                                    prenom,
                                                    adresse,
                                                    code_postal,
                                                    pays,
                                                    mail,
                                                    tel,
                                                    titre
                                                FROM
                                                    `details_commandes`
                                                INNER JOIN commandes
                                                ON details_commandes.`id_commande` = commandes.id_commande
                                                INNER JOIN clients
                                                ON commandes.id_client = clients.id_client
                                                INNER JOIN produits
                                                ON details_commandes.id_produit = produits.id_produit
                                                WHERE
                                                    commandes.`id_commande` = ?
                                                     
                                        ');
                                        
        $query -> execute([$commande]);
        $showOrderDetails = $query -> fetchAll(); 
        
        return $showOrderDetails; 
    }
    
    
    public function deleteOrder($id_commande)
    {
        
        $query = $this -> database->prepare('
                                                DELETE
                                                FROM
                                                    `commandes`
                                                WHERE
                                                    `id_commande` = ?
                                           ');
    
        $test = $query -> execute([$id_commande]);
        return $test;
    }
}