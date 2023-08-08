<?php
namespace controllers;

use models\Meal;
use controllers\SecurityController;

class MealController extends SecurityController
{
    private Meal $meal;
    
    public function __construct()
    {
        $this -> meal = new Meal();
    }
    
    public function listMeals():void
    {
        // récupérer les repas 
        $meals = $this -> meal -> getMeals();
        // transmettre au template pour les afficher 
        $template = "index";
        // à ne pas oublier de passer par le layout
        require "views/layout.phtml";
    }
    
    public function addMenus()
    {
        if($this -> isAdmin())
        {
            if(isset($_POST['titre']) && !empty($_POST['titre']) 
              && isset($_POST['details']) && !empty($_POST['details'])
              && isset($_POST['prix_unité']) && !empty($_POST['prix_unité'])
              && isset($_FILES['image']) && !empty($_FILES['image']))//$_FILES toujours on l'utilise pour recuperer l'image;
            {
                $titre = htmlspecialchars($_POST['titre']);
                $details = htmlspecialchars($_POST['details']);
                $prix_unite = htmlspecialchars($_POST['prix_unité']);
                $image = htmlspecialchars($_FILES['image']['name']);//name parce que on recupere seulement name d'image;
                
                var_dump($image);
                var_dump($_POST);
                echo "coucou1";
                $test = $this -> meal -> addMenu($titre,$details,$prix_unite,$image);
                echo "coucou2";
                var_dump($test);
                       
                if($test)
                {
                     $uploads_dir = 'views/images/meals';// c'est la ou on telecharge les images;
                     if (!empty($_FILES['image']['name']))//si le nom de l'image n'est pas vide
                     { 
                        echo "coucou";
                        $tmp_name = $_FILES["image"]["tmp_name"];
                        $name = $_FILES["image"]["name"];
                        $testimg = move_uploaded_file($tmp_name, "$uploads_dir/$name");
                        // var_dump($testimg);
                        if($testimg)
                        {
                            $message = "Votre menu est inséré";
                            header("location:index.php?action=addMenu&message=$message");//'message=$message' transmet la variable $message à la nouvelle page.
                        }
                    }
                }
                else
                {
                    $message = "Le menu n'a pas pu etre inséré";
                }
                
                if ($image['error'] == UPLOAD_ERR_OK) {
                  $uploadDir = 'views/images/meals';
                  $uploadFile = $uploadDir . basename($image['name']);
                  move_uploaded_file($image['tmp_name'], $uploadFile);
                
                  $imagePath = $uploadFile;
                } else 
                {
                  echo 'Error uploading file';
                }
                
                
                
            }
                $template = "admin/addMeal";
                require "views/layout.phtml"; 
        }
        else
        {
          header("location:index.php");
            exit();  
        }
    }
    
    public function modifMenus()
    {
        if($this -> isAdmin())
        {
            if(array_key_exists('id',$_GET) && is_numeric($_GET['id']))
            {
                $id_produit = $_GET['id'];
            
                $chosenMenu = $this -> meal -> getMealById($id_produit);
                
                $template = "admin/modifMenu";
                require "views/layout.phtml"; 
                    
                // on pré-rempli le formulaire par les informations de l'article qu'on vient de récupérer
            //  
            }
            else if(isset($_POST['titre']) && !empty($_POST['titre']) 
                  && isset($_POST['details']) && !empty($_POST['details'])
                  && isset($_POST['prix_unite']) && !empty($_POST['prix_unite'])
                  && isset($_FILES['image']) && !empty($_FILES['image']))
                {
                    
                    $titre = htmlspecialchars($_POST['titre']);
                    $details = htmlspecialchars($_POST['details']);
                    $prix_unite = htmlspecialchars($_POST['prix_unite']);
                    $image = htmlspecialchars($_FILES['image']['name']);
                    $id_produit = htmlspecialchars($_POST['id']);
                        
                    $modifMenu = $this -> meal -> modifMenu($titre,$details,$prix_unite,$image,$id_produit);
                    
                    if($modifMenu)
                    {
                        $uploads_dir = 'views/images/meals';// c'est la ou on telecharge les images;
                        if (!empty($_FILES['image']['name']))
                         { //si le nom de l'image n'est pas vide
                            $tmp_name = $_FILES["image"]["tmp_name"];
                            $name = $_FILES["image"]["name"];
                            $testimg = move_uploaded_file($tmp_name, "$uploads_dir/$name");

                            if($testimg)
                            {
                                $message = "L'article à bien été modifié";
                                header("location:index.php?action=modifMenu&message=$message");//'message=$message' transmet la variable $message à la nouvelle page.
                                exit();
                            }
                          }
                    }
        
                }
            else
            {
                $meals = $this -> meal -> getMeals();
                $template = "admin/modifMenu";
                require "views/layout.phtml"; 
            }
        }
        else
        {
            header("location:index.php");
            exit();
        }
    }
    
    
    public function deleteMenu()
    {
        if($this -> isAdmin())
        {
            if(array_key_exists('id',$_GET) && is_numeric($_GET['id']))
            {
                $id_produit = $_GET['id'];
                $menu = $this -> meal -> getMealById($id_produit);   
                $deleteMenu = $this -> meal -> deleteMenu($id_produit);
                
                if($deleteMenu)
                {
                    $uploads_dir = 'views/images/meals';
                    $filename = "$uploads_dir/".$menu['image'];
                    if (file_exists($filename)) 
                    {
                        $test = unlink($filename);
                        
                        if($test)
                        {
                            $message = "L'article à bien été supprimé";
                            header("location:index.php?action=modifMenu&message=$message");
                            exit();
                        }
                    } 
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