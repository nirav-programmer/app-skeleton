<?php

declare(strict_types=1);

/*
 * This file is part of app-skeleton.
 *
 * Copyright (c) 2018 Damien Carcel <damien.carcel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Carcel\User\Infrastructure\Security;

use Carcel\User\Domain\QueryFunction\GetUser;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private GetUser $getUser;

    public function __construct(GetUser $getUser)
    {
        $this->getUser = $getUser;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername(string $email): UserInterface
    {
        return $this->getUserByEmail($email);
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $this->getUserByEmail($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        // TODO: when encoded passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newEncodedPassword);
    }

    private function getUserByEmail(string $email): UserInterface
    {
        $user = $this->getUser->byEmail($email);

        if (null === $user) {
            throw new UsernameNotFoundException($email);
        }

        return new User($user->getEmail(), '', []);
    }
}