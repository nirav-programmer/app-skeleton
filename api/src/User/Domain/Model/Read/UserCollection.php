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

namespace Carcel\User\Domain\Model\Read;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class UserCollection
{
    private array $users;

    public function __construct(array $usersData)
    {
        $this->users = array_map(function (array $userData) {
            return new User(
                $userData['id'],
                $userData['firstName'],
                $userData['lastName'],
                $userData['email'],
            );
        }, $usersData);
    }

    public function normalize(): array
    {
        return array_map(function (User $user) {
            return [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
            ];
        }, $this->users);
    }
}
