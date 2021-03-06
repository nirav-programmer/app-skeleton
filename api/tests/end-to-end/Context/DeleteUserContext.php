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

namespace Carcel\Tests\EndToEnd\Context;

use Behat\Behat\Context\Context;
use Carcel\Tests\Fixtures\UserFixtures;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class DeleteUserContext implements Context
{
    private ResponseInterface $response;

    private KernelInterface $kernel;
    private RouterInterface $router;
    private Connection $connection;

    public function __construct(KernelInterface $kernel, RouterInterface $router, Connection $connection)
    {
        $this->kernel = $kernel;
        $this->router = $router;
        $this->connection = $connection;
    }

    /**
     * @When I delete a user
     */
    public function askForASpecificUser(): void
    {
        $this->response = $this->client()->request(
            'DELETE',
            $this->router->generate('api_delete_users_delete_item', [
                'id' => array_keys(UserFixtures::USERS_DATA)[0],
            ]),
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . AuthenticationContext::$TOKEN,
                ],
            ],
        );
    }

    /**
     * @Then the user should be deleted
     */
    public function userShouldBeDeleted(): void
    {
        Assert::same($this->response->getStatusCode(), 202);

        $query = <<<SQL
            SELECT * FROM user
            SQL;

        $statement = $this->connection->executeQuery($query);
        $results = $statement->fetchAll();

        Assert::count($results, count(UserFixtures::USERS_DATA) - 1);

        Assert::eq($this->filterQueriedUserData($results), $this->expectedUserCollectionAfterDeletion());
    }

    private function filterQueriedUserData(array $users): array
    {
        return array_map(function (array $queriedUser) {
            return [
                'id' => $queriedUser['id'],
                'email' => $queriedUser['email'],
                'firstName' => $queriedUser['first_name'],
                'lastName' => $queriedUser['last_name'],
            ];
        }, $users);
    }

    private function expectedUserCollectionAfterDeletion(): array
    {
        $normalizedFixtures = UserFixtures::getNormalizedUsers();

        return array_values(array_filter($normalizedFixtures, function (array $user) {
            return array_keys(UserFixtures::USERS_DATA)[0] !== $user['id'];
        }));
    }

    private function client(): HttpClientInterface
    {
        return $this->kernel->getContainer()->get('test.api_platform.client');
    }
}
