<?php
namespace App\Controller;

use App\Repository\FormationRepository;
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
     * 
     * @var FormationRepository
     */
    private $repository;
    
    function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/formations", name="formations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->repository->findAll();
        return $this->render("pages/formations.html.twig", [
            'formations' => $formations
        ]);
    }
    
}
