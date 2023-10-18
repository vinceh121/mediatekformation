<?php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;

/**
 *
 * @Route("/admin", name="admin_auth_")
 */
class AuthController extends AbstractController
{

    private ClientRegistry $registry;

    function __construct(ClientRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     *
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->registry->getClient('keycloak')->redirect();
    }
}

