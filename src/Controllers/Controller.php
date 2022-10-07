<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
// use App\Utils\Session; => comment utiliser d'un autre namespace ?


abstract class Controller
{
    private $loader;
    protected $twig;

   public function __construct()
   {
       $this->loader = new FilesystemLoader(ROOT. '/templates');
       $this->twig = new Environment($this->loader);
        $this->twig->addGlobal('session', $_SESSION); // que faire ? 
       // new Session;
   }
}
