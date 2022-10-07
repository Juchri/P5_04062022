<?php
namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\PostsModel;
use App\Utils\Session;

use DateTime;

class PostsController extends Controller
{
    /**
     * Cette méthode affichera une page listant toutes les annonces de la base de données
     * @return void 
     */
    public function index()
    {
        // On instancie le modèle correspondant à la table 'posts'
        $postsModel = new PostsModel;

        // On va chercher toutes les annonces actives
        $posts = $postsModel->findAll();

        // On génère la vue
        $this->twig->display('posts/index.html.twig', compact('posts'));
    }

      /**
     * Affiche 1e post
     * @param int $id Id de post 
     * @return void 
     */
    public function show(int $id)
    {
        // On instancie le modèle
        $postsModel = new PostsModel;
        // On va chercher 1 annonce
        $post = $postsModel->find($id);

        $commentModel = new CommentsModel;
        $postComments = $commentModel->findBy(['post_id' => $id, 'is_valid' => 1]);

        if ((Session::get('user')) && !empty(Session::get('user','id'))) {
                if (isset($_POST['comment']) && !empty($_POST['comment'])) {
                    $content = strip_tags($_POST['comment']);
                    $commentModel->setContent($content)
                                 ->setUserId(Session::get('user', 'id'))
                                 ->setPostId($id)
                                 ->setAuthor(Session::get('user', 'first_name') . ' ' . Session::get('user', 'last_name'));

                    if (in_array('ROLE_ADMIN', Session::get('user', 'roles'))) {
                        $commentModel->setIsValid(1);
                    } else {
                      Session::set('message',"Votre commentaire est bien ajouté ! Un admin doit le valider avant de l'afficher");
                    }
                    $commentModel->create();
                    header(('Location: index.php?p=posts/show/'.$id));
                }
            }

        // On envoie à la vue
        $this->twig->display('posts/show.html.twig', compact('post', 'postComments'));
    }
}