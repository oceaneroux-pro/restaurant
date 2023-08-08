<?php
namespace controllers;

use models\User;
use controllers\SecurityController;

class UserController extends SecurityController{
    
    private User $user;
    
    
    public function __construct()
    {
        $this -> user = new User();
    }
    
    public function createAccount()
    {
        // -->si le formulaire d'inscription à bien été envoyé.
        if(   isset($_POST['nom']) && !empty($_POST['nom']) 
              && isset($_POST['prenom']) && !empty($_POST['prenom'])
              && isset($_POST['anniversaire']) && !empty($_POST['anniversaire'])
              && isset($_POST['adresse']) && !empty($_POST['adresse'])
              && isset($_POST['codePostal']) && !empty($_POST['codePostal'])
              && isset($_POST['pays']) && !empty($_POST['pays'])
              && isset($_POST['tel']) && !empty($_POST['tel'])
              && isset($_POST['mail']) && !empty($_POST['mail'])
              && isset($_POST['mdp']) && !empty($_POST['mdp']))
        {
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $anniversaire = htmlspecialchars($_POST['anniversaire']);
            $adresse = htmlspecialchars($_POST['adresse']);
            $codePostal = htmlspecialchars($_POST['codePostal']);
            $pays = htmlspecialchars($_POST['pays']);
            $tel = htmlspecialchars($_POST['tel']);
            $mail = htmlspecialchars($_POST['mail']);
            $mdp = htmlspecialchars($_POST['mdp']);
            $mdp = password_hash($mdp,PASSWORD_DEFAULT);
            
            // -->si oui vérification si le mail existe déjà(à l'aide de la méthode getUserByEmail(?) du modèle).
            
            $verifMail = $this -> user -> getUserByEmail($mail);
            
            // si le mail n'existe pas alors on récupère tous les champs du formulaire (champs par champs)
            if($verifMail == false)
            {
                $test = $this -> user -> addUser($nom, $prenom, $anniversaire, $adresse, $codePostal, $pays, $tel, $mail, $mdp);
                if($test)
                {
                    $message = "Votre compte a bien été créé";
                }
                else
                {
                    $message = "Une erreur innatendue est survenue, veuillez réessayer";
                }
            }
            else
            {
                $message = "Ce compte existe déjà";
            }
        }
        
        $template = "user/createAccount";
        require "views/layout.phtml";
    }
    
    public function connexion(){
        //faire la vérification du pseudo et de mot de passe du client en les réccupérant depuis la BDD pour les comparer
         if(isset($_POST['mail']) && !empty($_POST['mail'])
            && isset($_POST['mdp']) && !empty($_POST['mdp'])) // si formulaire envoyé
        {
            $mail = htmlspecialchars($_POST['mail']); // récup mail
            $mdp = htmlspecialchars($_POST['mdp']); // récup mdp
            
            $verifMail = $this -> user -> getUserByEmail($mail);
            
            if($verifMail)
            {
                if(password_verify($mdp, $verifMail['mdp']))
                {
                    $_SESSION['client']['mail'] = $mail;
                    $_SESSION['client']['id_client'] = $verifMail['id_client'];
                    $_SESSION['client']['prenom'] = $verifMail['prenom'];
                    $message = "Bonjour, vous êtes connecté";
                    // Redirection vers la page d'accueil
                    header('location:index.php');
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
                $message = "Nom d'utilisateur";
            }
        }
        
        $template = "user/connect";
        require "views/layout.phtml";
    }
    
    public function deconnexion()
    {
        session_destroy();
        header("location:index.php?action=connexion");
    }
    
    
     public function afficheUserInfo()
    {
        if($this -> is_connect())
        {
            $id_client = $_SESSION['client']['id_client'];
                 
            $user = $this -> user -> afficheUserInfo($id_client); 
                // transmettre au template pour les afficher 
            if($user)
            {
                /*$_SESSION['user']['email'] = $email;
                $_SESSION['user']['LastName'] = $user['LastName'];
                $_SESSION['user']['FirstName'] = $user['FirstName'];
                $_SESSION['user']['BirthDate'] = $user['BirthDate'];
                $_SESSION['user']['Adresse'] = $user['Adresse'];
                $_SESSION['user']['Pays'] = $user['Pays'];
                $_SESSION['user']['City'] = $user['City'];
                $_SESSION['user']['PostalCode'] = $user['PostalCode'];
                $_SESSION['user']['PhoneNumber'] = $user['PhoneNumber'];*/
                        
                    // Redirection vers la page d'accueil
                    $template = "views/user/compteUser";
                    // à ne pas oublier de passer par le layout
                    require "views/layout.phtml";
            }
        }
        else
        {
            header("location:index.php");
            exit();
        }
    
    }
    
    
    public function modifyProfile()
    {
        
        if(array_key_exists('id',$_GET) && is_numeric($_GET['id']))
        {
                $id_client = $_GET['id'];
                $user = $this -> user -> afficheUserInfo($id_client); 
                    
                $template = "user/modifyProfile";
                require "views/layout.phtml"; 
        }
        else if(isset($_POST['nom']) && !empty($_POST['nom']) 
                && isset($_POST['prenom']) && !empty($_POST['prenom'])
                && isset($_POST['anniversaire']) && !empty($_POST['anniversaire'])
                && isset($_POST['adresse']) && !empty($_POST['adresse'])
                && isset($_POST['pays']) && !empty($_POST['pays'])
                && isset($_POST['codePostal']) && !empty($_POST['codePostal'])
                && isset($_POST['mail']) && !empty($_POST['mail'])
                && isset($_POST['tel']) && !empty($_POST['tel']))
        {
                $id_client = $_SESSION['client']['id_client'];
                $nom = htmlspecialchars($_POST['nom']);// html..
                $prenom = htmlspecialchars($_POST['prenom']);
                $anniversaire = htmlspecialchars($_POST['anniversaire']);
                $adresse = htmlspecialchars($_POST['adresse']);
                $pays = htmlspecialchars($_POST['pays']);
                $codePostal = htmlspecialchars($_POST['codePostal']);
                $tel = htmlspecialchars($_POST['tel']);
                $mail = htmlspecialchars($_POST['mail']);
                
                $changeProfile = $this -> user -> changeProfile($nom,$prenom,$anniversaire,$adresse,$pays,$codePostal,$tel,$mail,$id_client);
                
                if($changeProfile)
                {
                    $message = "Votre profil a bien été modifié";
                    header("location:index.php?action=compteUser&message=$message");//'message=$message' transmet la variable $message à la nouvelle page.
                    exit();
                }
        }
    } 
}