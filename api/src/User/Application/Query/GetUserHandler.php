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

namespace Carcel\User\Application\Query;

use Carcel\User\Domain\Exception\UserDoesNotExist;
use Carcel\User\Domain\Model\Read\User;
use Carcel\User\Domain\QueryFunction\GetUser as GetUserQueryFunction;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class GetUserHandler implements MessageHandlerInterface
{
    private $getUserQueryFunction;

    public function __construct(GetUserQueryFunction $getUserQueryFunction)
    {
        $this->getUserQueryFunction = $getUserQueryFunction;
    }

    public function __invoke(GetUser $getUser): User
    {
        $uuid = $getUser->identifier();

        if (null === $user = ($this->getUserQueryFunction)(Uuid::fromString($uuid))) {
            throw UserDoesNotExist::fromUuid($uuid);
        }

        return $user;
    }
}
