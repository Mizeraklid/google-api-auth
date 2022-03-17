<?php

namespace Mizeraklid\GoogleApiAuth\Event;

use Mizeraklid\GoogleApiAuth\Entity\GoogleCredentialInterface;
use Symfony\Contracts\EventDispatcher\Event;

class GoogleAuthCreatedEvent extends Event
{
    public const NAME = 'google-auth.created';

    /**
     * @var GoogleCredentialInterface
     */
    private $googleCredential;

    public function __construct(GoogleCredentialInterface $googleCredential)
    {
        $this->googleCredential = $googleCredential;
    }

    public function getGoogleCredential(): GoogleCredentialInterface
    {
        return $this->googleCredential;
    }
}