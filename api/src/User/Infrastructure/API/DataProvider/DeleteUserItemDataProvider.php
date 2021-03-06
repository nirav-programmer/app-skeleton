<?php

declare(strict_types=1);

/*
 * This file is part of app-skeleton.
 *
 * Copyright (c) 2020 Damien Carcel <damien.carcel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Carcel\User\Infrastructure\API\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Carcel\User\Application\Command\DeleteUser;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class DeleteUserItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): DeleteUser
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException(sprintf(
                'Identifier can only be a string, "%s" provided.',
                gettype($id)
            ));
        }

        $updateUser = new DeleteUser();
        $updateUser->identifier = $id;

        return $updateUser;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return DeleteUser::class === $resourceClass;
    }
}
