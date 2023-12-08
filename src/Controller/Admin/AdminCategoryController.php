<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\CategoryType;
use App\Entity\Categorie;

/**
 *
 * @Route("/admin/category", name="admin_category_")
 */
class AdminCategoryController extends AbstractController
{

    private CategorieRepository $categoryRepository;

    private EntityManagerInterface $em;

    public function __construct(CategorieRepository $categoryRepository, EntityManagerInterface $em)
    {
        $this->categoryRepository = $categoryRepository;
        $this->em = $em;
    }

    /**
     *
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $category = new Categorie();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();

            $this->addFlash('success', 'Nouvelle catégorie enregistrée');
            
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/category.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{categoryId}", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, int $categoryId): Response
    {
        $category = $this->categoryRepository->find($categoryId);

        if (!$category) {
            throw $this->createNotFoundException('Catégorie inconnue');
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();

            $this->addFlash('success', 'Changements enregistrés');
        }

        return $this->render('admin/category.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     *
     * @Route("/{categoryId}", name="delete", methods={"DELETE"})
     */
    public function delete(int $categoryId): Response
    {
        $category = $this->categoryRepository->find($categoryId);

        if (!$category) {
            throw $this->createNotFoundException('Catégorie inconnue');
        }

        $this->categoryRepository->remove($category, true);

        return new JsonResponse();
    }
}

