<?php
namespace App\Controllers;

use App\Models\UsersModel;

class AdminController extends Controller
{
    public function index() {
        if($this->isAdmin()){
            $this->twig->display('admin/index.html.twig');
        }
    }

    public function admin()
    {
        $this->twig->display('admin/index.html.twig');     
    }

        /**
     * Vérifie si on est admin
     * @return true 
     */
    private function isAdmin()
    {
        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos rôles
        if(isset($_SESSION['user']) && in_array('ROLE_ADMIN', $_SESSION['user']['roles'])){
            // On est admin
            return true;
        }else{
            // On n'est pas admin
            $_SESSION['erreur'] = "Vous n'avez pas accès à cette zone";
            header('Location: /');
            exit;
        }
    }
}