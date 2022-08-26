<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur des formations
 *
 * @author emds
 */
class FormationsController extends AbstractController {

    /**
     * @Route("/formations", name="formations")
     * @return Response
     */
    public function index(): Response{
        return $this->render("pages/formations.html.twig");
    }
    
}
