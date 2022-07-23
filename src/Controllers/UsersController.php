<?php
namespace App\Controllers;

use App\Core\Form;
use App\Models\UsersModel;
use App\Models\CommentsModel;

class UsersController extends Controller
{
    /**
     * Connexion des utilisateurs
     * @return void 
     */
    public function login(){
        unset($_SESSION['erreur']);
        // On vérifie si le formulaire est complet
        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
            // On va chercher dans la base de données l'utilisateur avec l'email entré
            $usersModel = new UsersModel;
            $userArray = $usersModel->findOneByEmail(strip_tags($_POST['email']));

            // Si l'utilisateur n'existe pas
            if(!$userArray){
                // On envoie un message de session
                $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /users/login');
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
                $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
                header('Location: /users/login');
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
        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
            // On "nettoie" l'adresse email
            $email = strip_tags($_POST['email']);

            // On chiffre le mot de passe
            $pass = password_hash($_POST['password'], PASSWORD_ARGON2I);

            // On hydrate l'utilisateur
            $user = new UsersModel;

            $user->setEmail($email)
                ->setPassword($pass)
            ;

            // On stocke l'utilisateur
            $user->create();
            unset($_SESSION['erreur']);
            $_SESSION['message'] = "Votre compte a bien été crée";
            header('Location: /users/login');
        }

        $this->twig->display('users/register.html.twig');     
    }

    /**
     * Déconnexion de l'utilisateur
     * @return exit 
     */
    public function logout(){
        unset($_SESSION['user']);
        unset($_SESSION['message']);
        unset($_SESSION['erreur']);
        header('Location: ?p=users/login');
        exit;
    }

    /*

Nouveautés
    */
    public function profile(int $id)
    {
        // On instancie le modèle
        $usersModel = new UsersModel;

        // On va chercher toutes les commentaires
        $profile = $usersModel->find($id);

        // Comment section
        $commentModel = new CommentsModel;

         // Unvalidated comments
        $CommentsUnvalidated = $commentModel->findBy(['is_validated' => '0']);

        // We find the id of the comment in bdd
        $commentId = $commentModel->getId();

                // Il doit manquer une boucle ici : comment relier les ids des commentaires à celuiq qu'on veut valider ?


            if (isset($_POST['validated']) && $_POST['validated'] == '1')
            {
                $now = new DateTime();
                $nowFormat = $now->format('Y-m-d');
                $commentModel->setIsValidated('1')
                             ->setValidatedAt($now);
                header(('Location: ?p=users/profile/'.$id));
            }


        // Generating view
        $this->twig->display('users/profile.html.twig', compact('profile','CommentsUnvalidated'));

    }

}