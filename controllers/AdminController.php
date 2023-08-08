<?php
namespace controllers;

use models\Admin;
use controllers\SecurityController;

class AdminController extends SecurityController{
    
    private Admin $admin;
    
    public function __construct()
    {
        $this -> admin = new Admin();
    }
    
    public function admin()
    {
        if(isset($_POST['mail']) && !empty($_POST['mail'])
            && isset($_POST['mdp']) && !empty($_POST['mdp'])) // si formulaire envoyé
        {
            
            $mail = htmlspecialchars($_POST['mail']); // récup mail
            $mdp = htmlspecialchars($_POST['mdp']); // récup mdp
            
            $verifMail = $this -> admin -> getAdminByEmail($mail);
            
            // var_dump($verifMail);
            
            if($verifMail)
            {
                if(password_verify($mdp, $verifMail['password']))
                {
                    $_SESSION['admin']['mail'] = $mail;
                    $_SESSION['admin']['id_admin'] = $verifMail['id_admin'];
                    $_SESSION['admin']['pseudo'] = $verifMail['pseudo'];
                    $_SESSION['admin']['password'] = $verifMail['password'];
                    $message = "Bonjour, vous êtes bien connecté.e";
                    // Redirection vers la page d'accueil
                    header('location:index.php?action=admin');
                    exit();
                }
                else
                {
                    $message = "Votre mot de passe est incorrect";
                }
                
            }
            else
            {
                // Affichage d'un message d'erreur
                $message = "Votre mail est incorrect";
            }
        }
        
        $template = "admin/homeAdmin";
        require "views/layout.phtml";
    }
        
    public function deconnexionAdmin()
    {
        session_destroy();
        header("location:index.php?action=admin");
    }
    
}