<?php

declare(strict_types=1);

namespace Mizeraklid\GoogleApiAuth\Controller;

use Mizeraklid\GoogleApiAuth\Event\GoogleAuthCreatedEvent;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GoogleUser;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class GoogleAuthController extends AbstractController
{
    protected function getClientName(): string
    {
        return 'google';
    }

    protected abstract function getGooglePermissions(): array;

    protected abstract function getRedirectUri(): string;

    protected abstract function getUserClass(): string;

    protected abstract function getGoogleCredentialClass(): string;

    protected abstract function getRedirectRouteAfterCallbackName(): string;

    /**
     * @Route("/google/auth", name="google_auth")
     *
     * @param ClientRegistry $clientRegistry
     *
     * @return Response
     */
    public function index(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry->getClient('google')->redirect($this->getGooglePermissions(), [
            'redirect_uri' => $this->getRedirectUri(),
            'prompt' => 'consent',
        ]);
    }

    /**
     * @param ClientRegistry $clientRegistry
     * @param ManagerRegistry $doctrine
     * @param LoggerInterface $logger
     *
     * @return RedirectResponse
     */
    public function redirectCallback(
        ClientRegistry $clientRegistry,
        ManagerRegistry $doctrine,
        LoggerInterface $logger
    ): RedirectResponse {
        $client = $clientRegistry->getClient('google');
        /** @var UserInterface $user */
        $user = $doctrine->getRepository($this->getUserClass())
            ->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
        try {
            // the exact class depends on which provider you're using
            $token = $client->getAccessToken();
            /** @var GoogleUser $userFromToken */
            $userFromToken = $client->fetchUserFromToken($token);
            $googleCredential = $doctrine->getRepository($this->getGoogleCredentialClass())->findOneBy([
                'email' => $userFromToken->getEmail()
            ]);
            if (is_null($googleCredential)) {
                $className = $this->getGoogleCredentialClass();
                $googleCredential = new $className();
            }
            $googleCredential->setAccessToken($token->getToken());
            if (!is_null($token->getExpires())) {
                $googleCredential->setExpiresAt((new DateTimeImmutable())->setTimestamp($token->getExpires()));
            }
            $googleCredential->setRefreshToken($token->getRefreshToken());
            $googleCredential->setIdToken($token->getValues()['id_token']);
            $googleCredential->setUser($user);
            if (!is_null($userFromToken->getEmail())) {
                $googleCredential->setEmail($userFromToken->getEmail());
            }

            $entityManager = $doctrine->getManager();
            $entityManager->persist($googleCredential);
            $entityManager->flush();

            $event = new GoogleAuthCreatedEvent($googleCredential);
            $dispatcher = new EventDispatcher();
            $dispatcher->dispatch($event, GoogleAuthCreatedEvent::NAME);

        } catch (IdentityProviderException $e) {
            $logger->error($e->getMessage());
        }

        return $this->redirectToRoute($this->getRedirectRouteAfterCallbackName());
    }
}
