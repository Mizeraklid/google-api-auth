<?php

namespace Mizeraklid\GoogleApiAuth\Controller;

use Doctrine\Persistence\ManagerRegistry;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Mizeraklid\GoogleApiAuth\Entity\GoogleCredentialInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class GoogleAuthControllerExample extends GoogleAuthController
{
    //@todo override
    protected function getGooglePermissions(): array
    {
        return [
            'https://www.googleapis.com/auth/calendar.events',
            'https://www.googleapis.com/auth/calendar',
        ];
    }

    //@todo override
    protected function getRedirectUri(): string
    {
        return $this->generateUrl('google_auth_callback');
    }

    //@todo override
    protected function getUserClass(): string
    {
        return UserInterface::class;
    }

    //@todo override
    protected function getGoogleCredentialClass(): string
    {
        return GoogleCredentialInterface::class;
    }

    /**
     * @Route("/google/auth", name="google_auth")
     */
    public function index(ClientRegistry $clientRegistry): Response
    {
        return parent::index($clientRegistry); // TODO: change routes
    }

    /**
     * @Route("/google/callback", name="google_redirect")
     */
    public function redirectCallback(
        ClientRegistry $clientRegistry,
        ManagerRegistry $doctrine,
        LoggerInterface $logger
    ): RedirectResponse {
        return parent::redirectCallback($clientRegistry, $doctrine, $logger); // TODO: change routes
    }
}