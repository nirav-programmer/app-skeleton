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

namespace Carcel\User\Infrastructure\Persistence\InMemory\QueryFunction;

use Carcel\User\Domain\Model\Read\UserCollection;
use Carcel\User\Domain\Model\Write\User;
use Carcel\User\Domain\QueryFunction\GetUserCollection;
use Carcel\User\Domain\Repository\UserRepository;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class GetUserCollectionFromMemory implements GetUserCollection
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(int $numberOfUsers, int $userPage): UserCollection
    {
        $persistedUsers = $this->repository->findAll();
        $usersToReturn = array_slice(
            $persistedUsers,
            $numberOfUsers * ($userPage - 1),
            $numberOfUsers
        );

        return new UserCollection($this->normalizeUsers($usersToReturn));
    }

    private function normalizeUsers(array $users): array
    {
        return array_map(function (User $user) {
            return [
                'id' => $user->id()->toString(),
                'email' => (string) $user->email(),
                'firstName' => (string) $user->firstName(),
                'lastName' => (string) $user->lastName(),
            ];
        }, $users);
    }
}
