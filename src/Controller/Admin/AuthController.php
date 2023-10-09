<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\AdminLoginType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 *
 * @Route("/admin", name="admin_auth_")
 */
class AuthController extends AbstractController
{

    /**
     *
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(AdminLoginType::class);

        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error != null) {
            $error = $error->getMessage();
        }

        return $this->render("admin/login.html.twig", [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }
}

