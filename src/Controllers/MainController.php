<?php
namespace App\Controllers;

use App\Models\ContactModel;
use App\Utils\Session;


use DateTime;

class MainController extends Controller
{
    public function index()
    {
        $contactModel = new ContactModel;
        $allMessages = $contactModel->findAll();

        if (isset($_POST['validate'])) {
            $mail = strip_tags($_POST['mail']);
            $first_name = strip_tags($_POST['first_name']);
            $last_name = strip_tags($_POST['last_name']);
            $content = strip_tags($_POST['content']);
            $contactModel
                ->setFirstName($first_name)
                ->setLastName($last_name)
                ->setMail($mail)
                ->setContent($content)
                ->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));

            $contactModel->create();

            Session::set('message',"Votre message a bien été envoyé !");
        }

        $this->twig->display('main/index.html.twig');
    }


}
