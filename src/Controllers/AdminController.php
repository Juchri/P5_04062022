<?php
namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\UsersModel;

class AdminController extends Controller
{
    public function index() {
        if($this->isAdmin()){
            $this->twig->display('admin/index.html.twig');     
        }
    }

    public function posts() {
        if($this->isAdmin()){
            $this->twig->display('admin/posts/index.html.twig');     
        }
    }

    public function comments() {
        if($this->isAdmin()){
            $commentModel = new CommentsModel;

            if (isset($_POST['valider'])) {
                $commentId = $_POST['commentId'];
                $commentArray = $commentModel->find($commentId);
                if($commentArray){
                    $comment = $commentModel->hydrate($commentArray);
                    $comment->setIsValid(1);
                    $comment->update();
                }
                header(('Location: index.php?p=admin/comments'));
            } elseif (isset($_POST['supprimer'])) {
                $commentId = $_POST['commentId'];
                $commentModel->delete($commentId);
                header(('Location: index.php?p=admin/comments'));
            }

            $allComments = $commentModel->findAll();
            $this->twig->display('admin/comments/index.html.twig', ['allComments' => $allComments]);     
        }
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
            header('Location: /post');
            exit;
        }
    }
}