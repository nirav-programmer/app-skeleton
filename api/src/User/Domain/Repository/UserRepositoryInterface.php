<?php

declare(strict_types=1);

/*
 * This file is part of SymfonySkeleton.
 *
 * Copyright (c) 2018 Damien Carcel <damien.carcel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Carcel\User\Domain\Repository;

use Carcel\User\Domain\Model\Write\User;
use Ramsey\Uuid\UuidInterface;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @return User
     */
    public function find(UuidInterface $uuid): ?User;

    public function save(User $user): void;

    public function delete(User $user): void;
}
