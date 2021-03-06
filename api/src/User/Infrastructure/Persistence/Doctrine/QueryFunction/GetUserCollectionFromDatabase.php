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

namespace Carcel\User\Infrastructure\Persistence\Doctrine\QueryFunction;

use Carcel\User\Domain\Model\Read\UserCollection;
use Carcel\User\Domain\QueryFunction\GetUserCollection;
use Doctrine\DBAL\Connection;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class GetUserCollectionFromDatabase implements GetUserCollection
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(int $numberOfUsers, int $userPage): UserCollection
    {
        $query = <<<SQL
            SELECT id, email, first_name AS firstName, last_name AS lastName FROM user
            LIMIT :limit OFFSET :offset;
            SQL;
        $parameters = ['limit' => $numberOfUsers, 'offset' => ($userPage - 1) * $numberOfUsers];
        $types = ['limit' => \PDO::PARAM_INT, 'offset' => \PDO::PARAM_INT];

        $statement = $this->connection->executeQuery($query, $parameters, $types);
        $result = $statement->fetchAll();

        return new UserCollection($result);
    }
}
