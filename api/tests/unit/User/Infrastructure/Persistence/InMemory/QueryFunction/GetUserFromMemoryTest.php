<?php

declare(strict_types=1);

/*
 * This file is part of app-skeleton.
 *
 * Copyright (c) 2019 Damien Carcel <damien.carcel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Carcel\Tests\Unit\User\Infrastructure\Persistence\InMemory\QueryFunction;

use Carcel\Tests\Fixtures\UserFixtures;
use Carcel\User\Domain\Model\Read\User;
use Carcel\User\Domain\Repository\UserRepositoryInterface;
use Carcel\User\Infrastructure\Persistence\InMemory\QueryFunction\GetUserFromMemory;
use Carcel\User\Infrastructure\Persistence\InMemory\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class GetUserFromMemoryTest extends TestCase
{
    /** @var GetUserFromMemory */
    private $getUserFromMemory;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->getUserFromMemory = new GetUserFromMemory($this->instantiateInMemoryUserRepository());
    }

    /** @test */
    public function itGetsAUser(): void
    {
        $user = ($this->getUserFromMemory)(Uuid::fromString('02432f0b-c33e-4d71-8ba9-a5e3267a45d5'));

        static::assertUserShouldBeRetrieved($user, '02432f0b-c33e-4d71-8ba9-a5e3267a45d5');
    }

    /** @test */
    public function itDoesntGetAUserThatDoesNotExist(): void
    {
        $user = ($this->getUserFromMemory)(Uuid::fromString(UserFixtures::ID_OF_NON_EXISTENT_USER));

        static::assertNull($user);
    }

    private function assertUserShouldBeRetrieved(User $user, string $usersId): void
    {
        static::assertSame($user->normalize(), UserFixtures::getNormalizedUser($usersId));
    }

    private function instantiateInMemoryUserRepository(): UserRepositoryInterface
    {
        $repository = new UserRepository();

        $users = UserFixtures::instantiateUserEntities();
        foreach ($users as $user) {
            $repository->save($user);
        }

        return $repository;
    }
}