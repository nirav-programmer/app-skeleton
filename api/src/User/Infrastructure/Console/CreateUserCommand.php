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

namespace Carcel\User\Infrastructure\Console;

use Carcel\User\Application\Command\CreateUser;
use Carcel\User\Application\Command\CreateUserHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Damien Carcel <damien.carcel@gmail.com>
 */
final class CreateUserCommand extends Command
{
    protected static $defaultName = 'carcel:user:create';

    private ValidatorInterface $validator;
    private CreateUserHandler $handler;

    public function __construct(ValidatorInterface $validator, CreateUserHandler $handler)
    {
        parent::__construct();

        $this->validator = $validator;
        $this->handler = $handler;
    }

    protected function configure(): void
    {
        $this->setDescription('Create a user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $createUser = new CreateUser();

        $createUser->firstName = $helper->ask($input, $output, new Question('Please enter your first name: '));
        $createUser->lastName = $helper->ask($input, $output, new Question('Please enter your last name: '));
        $createUser->email = $helper->ask($input, $output, new Question('Please enter your email: '));
        $createUser->password = $helper->ask($input, $output, new Question('Please enter your password: '));

        $violations = $this->validator->validate($createUser);
        if (0 < $violations->count()) {
            $output->writeln('Cannot create user because of the following violations:');
            foreach ($violations as $violation) {
                $output->writeln($violation->getMessage());
            }
        }

        ($this->handler)($createUser);

        return 0;
    }
}
