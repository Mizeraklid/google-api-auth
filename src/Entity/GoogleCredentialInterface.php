<?php

namespace Mizeraklid\GoogleApiAuth\Entity;

use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface;

interface GoogleCredentialInterface
{
    public function getId(): int;

    public function getAccessToken(): string;

    public function setAccessToken(string $access_token): self;

    public function getRefreshToken(): ?string;

    public function setRefreshToken(?string $refresh_token): self;

    public function getIdToken(): ?string;

    public function setIdToken(?string $id_token): self;

    public function getExpiresAt(): ?DateTimeImmutable;

    public function setExpiresAt(?DateTimeImmutable $expires_at): self;

    public function getUser(): UserInterface;

    public function setUser(UserInterface $user): self;

    public function getEmail(): string;

    public function setEmail(string $email): self;
}