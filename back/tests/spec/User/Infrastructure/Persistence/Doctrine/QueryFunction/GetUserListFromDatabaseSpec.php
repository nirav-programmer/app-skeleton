<?php

declare(strict_types=1);

/*
 * This file is part of AppSkeleton.
 *
 * Copyright (c) 2018 Damien Carcel <damien.carcel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Carcel\User\Infrastructure\Persistence\Doctrine\QueryFunction;

use Carcel\User\Domain\QueryFunction\GetUserList;
use Carcel\User\Infrastructure\Persistence\Doctrine\QueryFunction\GetUserListFromDatabase;
use Doctrine\DBAL\Connection;
use PhpSpec\ObjectBehavior;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
class GetUserListFromDatabaseSpec extends ObjectBehavior
{
    function let(Connection $connection)
    {
        $this->beConstructedWith($connection);
    }

    function it_is_a_get_user_list_query()
    {
        $this->shouldHaveType(GetUserListFromDatabase::class);
        $this->shouldImplement(GetUserList::class);
    }
}