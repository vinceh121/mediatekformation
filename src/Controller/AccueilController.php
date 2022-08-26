<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur de l'accueil
 *
 * @author emds
 */
class AccueilController extends AbstractController{
      
    /**
     * @Route("/", name="accueil")
     * @return Response
     */
    public function index(): Response{
        return $this->render("pages/accueil.html.twig");  
    }
    
}
