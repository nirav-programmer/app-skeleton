<?php

declare(strict_types=1);

/*
 * This file is part of AppSkeleton.
 *
 * Copyright (c) 2017 Damien Carcel <damien.carcel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Acceptance\Context;

use App\Application\Query\GetUserList as GetUserListQuery;
use App\Application\Query\GetUserListHandler;
use App\Domain\Model\Read\UserList;
use App\Tests\Fixtures\UserFixtures;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

/**
 * This is a very bad acceptance test context, as it makes use of the framework
 * (router, request handling), which is not business. This is only for demo.
 *
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
class ManageUsersContext implements Context
{
    /** @var GetUserListHandler */
    private $getUserList;

    /** @var UserList */
    private $userList;

    /**
     * @param GetUserListHandler $getUserList
     */
    public function __construct(GetUserListHandler $getUserList)
    {
        $this->getUserList = $getUserList;
    }

    /**
     * @throws \Exception
     *
     * @When I ask for the list of the users
     */
    public function listAllTheUsers(): void
    {
        $this->userList = $this->getUserList->handle(new GetUserListQuery(10, 1));
    }

    /**
     * @Then all the users should be retrieved
     */
    public function allUsersShouldBeRetrieved(): void
    {
        Assert::same($this->userList->normalize(), UserFixtures::getNormalizedUsers());
    }
}
