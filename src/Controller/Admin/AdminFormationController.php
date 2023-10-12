<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\CategorieRepository;
use App\Repository\PlaylistRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 * @Route("/admin/formation", name="admin_formation_")
 */
class AdminFormationController extends AbstractController
{

    private FormationRepository $formationRepository;

    private CategorieRepository $categoryRepository;

    private PlaylistRepository $playlistsRepository;

    private EntityManagerInterface $em;

    public function __construct(FormationRepository $formationRepository, CategorieRepository $categoryRepository, PlaylistRepository $playlistsRepository, EntityManagerInterface $em)
    {
        $this->formationRepository = $formationRepository;
        $this->categoryRepository = $categoryRepository;
        $this->playlistsRepository = $playlistsRepository;
        $this->em = $em;
    }

    /**
     *
     * @Route("/{formationId}", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, int $formationId): Response
    {
        $formation = $this->formationRepository->find($formationId);

        if (!$formation) {
            throw $this->createNotFoundException('Formation inconnue');
        }

        $categories = $this->categoryRepository->findAll();
        $playlists = $this->playlistsRepository->findAll();

        $form = $this->createForm(FormationType::class, $formation, [
            'categories' => $categories,
            'playlists' => $playlists
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();

            $this->addFlash('success', 'Changements enregistrés');
        }

        return $this->render('admin/formation.html.twig', [
            'form' => $form->createView(),
            'formation' => $formation
        ]);
    }

    /**
     *
     * @Route("/{formationId}", name="delete", methods={"DELETE"})
     */
    public function delete(int $formationId): Response
    {
        $formation = $this->formationRepository->find($formationId);

        if (!$formation) {
            throw $this->createNotFoundException('Formation inconnue');
        }

        $this->formationRepository->remove($formation, true);

        return new JsonResponse();
    }
}

