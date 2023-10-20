<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PlaylistRepository;
use App\Repository\FormationRepository;
use App\Repository\CategorieRepository;

class DashboardController extends AbstractController
{

    /**
     *
     * @Route("/admin", name="admin_dashboard")
     */
    public function dashboard(FormationRepository $formationRepo, PlaylistRepository $playlistRepo, CategorieRepository $categoryRepository): Response
    {
        $formations = $formationRepo->findAll();
        $playlists = $playlistRepo->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'formations' => $formations,
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }
}

