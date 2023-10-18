<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class KeycloakAuthenticator extends OAuth2Authenticator implements AuthenticationEntryPointInterface
{

    private UrlGeneratorInterface $router;

    private EntityManagerInterface $em;

    private ClientRegistry $clientRegistry;

    public function __construct(UrlGeneratorInterface $router, EntityManagerInterface $em, ClientRegistry $clientRegistry)
    {
        $this->router = $router;
        $this->em = $em;
        $this->clientRegistry = $clientRegistry;
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('keycloak');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(new UserBadge($accessToken->getToken(), function () use ($accessToken, $client) {
            /** @var User $user */
            $keycloakUser = $client->fetchUserFromToken($accessToken);

            $existingUser = $this->em->getRepository(User::class)->findOneBy([
                'id' => $keycloakUser->getId()
            ]);

            if ($existingUser) {
                return $existingUser;
            }

            $user = new User();
            $user->setId($keycloakUser->getId());
            $user->setEmail($keycloakUser->getEmail());
            $user->setRoles([
                'ROLE_ADMIN'
            ]);

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }));
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'admin_auth_callback';
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('admin_dashboard'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw new AccessDeniedException(previous: $exception);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('admin_auth_login'), Response::HTTP_TEMPORARY_REDIRECT);
    }
}
