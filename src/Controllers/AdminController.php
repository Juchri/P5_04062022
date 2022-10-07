<?php
namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\PostsModel;
use App\Models\UsersModel;
use App\Utils\Session;

class AdminController extends Controller
{
    public function index() {
        if($this->isAdmin()){
            $this->twig->display('admin/index.html.twig');     
        }
    }

    public function posts() {
        if($this->isAdmin()){
            $postModel = new PostsModel;
            $allPosts = $postModel->findAll();

            if (isset($_POST['supprimer'])) {
                $postId = $_POST['postId'];
                $postModel->delete($postId);
                header(('Location: /admin/posts'));
            }


            $this->twig->display('admin/posts/index.html.twig', ['posts' => $allPosts]);     
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

    public function add() {
        if($this->isAdmin()){
            $postModel = new PostsModel;

            if (isset($_POST['title']) && !empty($_POST['title']) && isset($_POST['content']) && !empty($_POST['content']) ) {
                $title = filter_input(INPUT_POST, 'title');
                $content = filter_input(INPUT_POST, 'content');
                $postModel
                    ->settitle($title)
                    ->setContent($content)
                    ->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'))
                    ->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                
                $postModel->create();
                header(('Location: index.php?p=admin/posts'));
            }
            $this->twig->display('admin/posts/add.html.twig');     
        }
    }

    public function update(int $id) {
        if($this->isAdmin()){
            $postModel = new PostsModel;
            $postArray = $postModel->find($id);
            $post = $postModel->hydrate($postArray);

            if (isset($_POST['title']) && !empty($_POST['title']) && isset($_POST['content']) && !empty($_POST['content']) ) {
                $title = strip_tags($_POST['title']);
                $content = strip_tags($_POST['content']);
                $post
                    ->setTitle($title)
                    ->setContent($content)
                    ->setUpdatedAt((new \DateTime())->format('Y-m-d H:i:s'));
                
                $post->update();
                header(('Location: index.php?p=admin/posts'));
            }
        
        $this->twig->display('admin/posts/update.html.twig', ['post' => $post]);     
        }

    }


        /**
     * Vérifie si on est admin
     * @return true 
     */
    private function isAdmin()
    {
        // On vérifie si on est connecté et si "ROLE_ADMIN" est dans nos rôles


        if (Session::get('user') && in_array('ROLE_ADMIN', Session::get('user')['roles'])){
            // On est admin
            return true;
        }else{
            // On n'est pas admin
            Session::set('erreur',"Vous n'avez pas accès à cette zone");
               // header('Location: index.php?p=post');
        }
    }
}