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

namespace Carcel\Tests\EndToEnd\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use Webmozart\Assert\Assert;

/**
 * Manages users authentications.
 *
 * @todo: Those methods are empty for now, and will be used in https://github.com/damien-carcel/app-skeleton/issues/18
 *
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
class AuthenticationContext extends RawMinkContext
{
    /**
     * @Given I am logged as an administrator
     */
    public function iAmLoggedAsAnAdministrator(): void
    {
        Assert::true(true);
    }
}