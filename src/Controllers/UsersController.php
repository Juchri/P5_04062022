<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;
use App\Utils\Session;

class UsersController extends Controller
{
    /**
     * Connexion des utilisateurs
     * @return void
     */
    public function login(){

        //unset($_SESSION['erreur']);
        Session::forget('erreur'); 

        // On vérifie si le formulaire est complet
        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
            // On va chercher dans la base de données l'utilisateur avec l'email entré
            $usersModel = new UsersModel;
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
            $userArray = $usersModel->findOneByEmail($email);

            // Si l'utilisateur n'existe pas
            if(!$userArray){
                // On envoie un message de session
                if(Session::get('erreur')){
                    pint_r("L\'adresse e-mail et/ou le mot de passe est incorrect");
                   // header('Location: index.php?p=post');
                }
                header('Location: index.php?p=/users/login');
                exit;
            }

            // L'utilisateur existe
            $user = $usersModel->hydrate($userArray);

            // On vérifie si le mot de passe est correct
            if(password_verify($_POST['password'], $user->getPassword())){
                // Le mot de passe est bon
                // On crée la session
                $user->setSession();
                header('Location: ?p=posts');
                exit;
            }else{
                // Mauvais mot de passe
                if(Session::get('erreur')){
                    echo "L\'adresse e-mail et/ou le mot de passe est incorrect";
                   // header('Location: index.php?p=post');
                }
                header('Location: index.php?p=/users/login');
                exit;
            }

        }
    
        $this->twig->display('users/login.html.twig');     
    }

    /**
     * Inscription des utilisateurs
     * @return void 
     */
    public function register()
    {
        // On vérifie si le formulaire est valide
        if(
            isset($_POST['firstName']) && !empty($_POST['firstName']) &&
            isset($_POST['lastName']) && !empty($_POST['lastName']) &&
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password']) && !empty($_POST['password'])){
            // On "nettoie" l'adresse email
            $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
            $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

            // On chiffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            // On hydrate l'utilisateur
            $user = new UsersModel;

            $user->setFirst_name($firstName)
                ->setLast_name($lastName)
                ->setEmail($email)
                ->setPassword($pass)
            ;

            // On stocke l'utilisateur
            $user->create();

            unset($_SESSION['erreur']);
            $_SESSION['message'] = "Votre compte a bien été créé";

            //Session::forget('erreur');
            //Session::set('message',"Votre compte a bien été créé");

        header('Location: ?p=users/login');
        }

        $this->twig->display('users/register.html.twig');
    }

    public function profil()
    {
        $this->twig->display('users/profil.html.twig');
    }


    /**
     * Déconnexion de l'utilisateur
     * @return exit
     */

    public function logout(){

        Session::forget('user');
        Session::forget('message');
        Session::forget('erreur');

        header('Location: index.php?p=/users/login');
        exit;
    }

}