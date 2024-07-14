<?php

return [
    'commands' => [
        App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommand::class =>
            App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommandHandler::class,
        App\AuthContext\Application\User\Command\UpdateUserCommand\UpdateUserCommand::class =>
            App\AuthContext\Application\User\Command\UpdateUserCommand\UpdateUserCommandHandler::class,

    ],
    'queries' => [
        App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQuery::class =>
            App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQueryHandler::class,
        \App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQuery::class =>
            \App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQueryHandler::class,
        \App\AuthContext\Application\Client\Query\GetClientPasswordQuery\GetClientPasswordQuery::class =>
            \App\AuthContext\Application\Client\Query\GetClientPasswordQuery\GetClientPasswordQueryHandler::class,
        \App\AuthContext\Application\User\Query\FindUserByIdQuery\FindByIdQuery::class =>
            \App\AuthContext\Application\User\Query\FindUserByIdQuery\FindByIdQueryHandler::class,
    ],
];
