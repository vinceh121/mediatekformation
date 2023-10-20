<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Playlist;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PlaylistType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 * @Route("/admin/playlist", name="admin_playlist_")
 */
class AdminPlaylistController extends AbstractController
{

    private FormationRepository $formationRepository;

    private PlaylistRepository $playlistRepository;

    private EntityManagerInterface $em;

    public function __construct(FormationRepository $formationRepository, PlaylistRepository $playlistRepository, EntityManagerInterface $em)
    {
        $this->formationRepository = $formationRepository;
        $this->playlistRepository = $playlistRepository;
        $this->em = $em;
    }

    /**
     *
     * @Route("/{playlistId}", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, int $playlistId): Response
    {
        $playlist = $this->playlistRepository->find($playlistId);
        $pickerFormations = $this->formationRepository->findBy([
            'playlist' => null
        ]);

        if (!$playlist) {
            throw $this->createNotFoundException('Playlist inconnue');
        }

        $origFormations = $playlist->getFormations()->getValues();

        $form = $this->createForm(PlaylistType::class, clone $playlist, [
            'formations' => array_merge($playlist->getFormations()
                ->getValues(), $pickerFormations)
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Playlist */
            $newPlaylist = $form->getData();

            foreach ($origFormations as $fOrig) {
                if (!$newPlaylist->getFormations()->contains($fOrig)) {
                    $fOrig->setPlaylist(null);
                }
            }

            foreach ($newPlaylist->getFormations() as $fDest) {
                if (!in_array($fDest, $origFormations)) {
                    $fDest->setPlaylist($playlist);
                }
            }

            $this->em->flush();

            $this->addFlash('success', 'Changements enregistrés');
        }

        return $this->render('admin/playlist.html.twig', [
            'form' => $form->createView(),
            'playlist' => isset($newPlaylist) ? $newPlaylist : $playlist, // this is to force updating the form on POSTs
            'pickerFormations' => $pickerFormations
        ]);
    }

    /**
     *
     * @Route("/{playlistId}", name="delete", methods={"DELETE"})
     */
    public function delete(int $playlistId): Response
    {
        $playlist = $this->playlistRepository->find($playlistId);

        if (!$playlist) {
            throw $this->createNotFoundException('Playlist inconnue');
        }

        if ($playlist->getFormations()->count() !== 0) {
            return new JsonResponse([
                'error' => 'La playlist doit être vide pour être supprimée'
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->playlistRepository->remove($playlist, true);

        return new JsonResponse();
    }
}

