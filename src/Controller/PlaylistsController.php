<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of PlaylistsController
 *
 * @author emds
 */
class PlaylistsController extends AbstractController
{

    private const PLAYLIST_TEMPLATE = "pages/playlists.html.twig";

    /**
     *
     * @var PlaylistRepository
     */
    private $playlistRepository;

    /**
     *
     * @var FormationRepository
     */
    private $formationRepository;

    /**
     *
     * @var CategorieRepository
     */
    private $categorieRepository;

    function __construct(PlaylistRepository $playlistRepository, CategorieRepository $categorieRepository, FormationRepository $formationRespository)
    {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }

    /**
     *
     * @Route("/playlists", name="playlists")
     * @return Response
     */
    public function index(): Response
    {
        $playlists = $this->playlistRepository->findAllOrder('p.name', 'ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PLAYLIST_TEMPLATE, [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }

    /**
     *
     * @Route("/playlists/tri/{champ}/{ordre}", name="playlists.sort")
     * @param string $champ
     * @param string $ordre
     * @return Response
     */
    public function sort(string $champ, string $ordre): Response
    {
        switch ($champ) {
            case 'name':
                $fullField = 'p.name';
                break;
            case 'formationsCount':
                $fullField = 'formationsCount';
                break;
            default:
                return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        $playlists = $this->playlistRepository->findAllOrder($fullField, $ordre);

        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PLAYLIST_TEMPLATE, [
            'playlists' => $playlists,
            'categories' => $categories
        ]);
    }

    /**
     *
     * @Route("/playlists/recherche/{champ}/{table}", name="playlists.findallcontain")
     * @param string $champ
     * @param Request $request
     * @param string $table
     * @return Response
     */
    public function findAllContain(string $champ, Request $request, string $table = ""): Response
    {
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PLAYLIST_TEMPLATE, [
            'playlists' => $playlists,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }

    /**
     *
     * @Route("/playlists/playlist/{id}", name="playlists.showone")
     * @param int $id
     * @return Response
     */
    public function showOne(int $id): Response
    {
        $playlist = $this->playlistRepository->find($id);
        $playlistCategories = $this->categorieRepository->findAllForOnePlaylist($id);
        $playlistFormations = $this->formationRepository->findAllForOnePlaylist($id);
        return $this->render(self::PLAYLIST_TEMPLATE, [
            'playlist' => $playlist,
            'playlistcategories' => $playlistCategories,
            'playlistformations' => $playlistFormations
        ]);
    }
}
