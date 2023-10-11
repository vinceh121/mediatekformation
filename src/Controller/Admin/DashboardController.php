<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PlaylistRepository;
use App\Repository\FormationRepository;

class DashboardController extends AbstractController
{

    /**
     *
     * @Route("/admin", name="admin_dashboard")
     */
    public function dashboard(FormationRepository $formationRepo, PlaylistRepository $playlistRepo): Response
    {
        $formations = $formationRepo->findAllOrderBy('publishedAt', 'ASC');
        $playlists = $playlistRepo->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'formations' => $formations,
            'playlists' => $playlists
        ]);
    }
}

