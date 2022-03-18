<?php

declare(strict_types=1);

namespace Mizeraklid\GoogleApiAuth\Entity;

use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface;

class GoogleCredentialExample implements GoogleCredentialInterface
{

    public function getId(): int
    {
        // TODO: Implement getId() method.
    }

    public function getAccessToken(): string
    {
        // TODO: Implement getAccessToken() method.
    }

    public function setAccessToken(string $access_token): GoogleCredentialInterface
    {
        // TODO: Implement setAccessToken() method.
    }

    public function getRefreshToken(): ?string
    {
        // TODO: Implement getRefreshToken() method.
    }

    public function setRefreshToken(?string $refresh_token): GoogleCredentialInterface
    {
        // TODO: Implement setRefreshToken() method.
    }

    public function getIdToken(): ?string
    {
        // TODO: Implement getIdToken() method.
    }

    public function setIdToken(?string $id_token): GoogleCredentialInterface
    {
        // TODO: Implement setIdToken() method.
    }

    public function getExpiresAt(): ?DateTimeImmutable
    {
        // TODO: Implement getExpiresAt() method.
    }

    public function setExpiresAt(?DateTimeImmutable $expires_at): GoogleCredentialInterface
    {
        // TODO: Implement setExpiresAt() method.
    }

    public function getUser(): UserInterface
    {
        // TODO: Implement getUser() method.
    }

    public function setUser(UserInterface $user): GoogleCredentialInterface
    {
        // TODO: Implement setUser() method.
    }

    public function getEmail(): string
    {
        // TODO: Implement getEmail() method.
    }

    public function setEmail(string $email): GoogleCredentialInterface
    {
        // TODO: Implement setEmail() method.
    }
}