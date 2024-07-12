<?php

return [
    'commands' => [
        App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommand::class =>
            App\AuthContext\Application\User\Command\RegisterUserCommand\RegisterUserCommandHandler::class,
    ],
    'queries' => [
        App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQuery::class =>
            App\AuthContext\Application\User\Query\GeneratePasswordGrantClientAccessTokenQuery\GeneratePasswordGrantClientAccessTokenQueryHandler::class,
        \App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQuery::class =>
            \App\AuthContext\Application\User\Query\FindUserByEmailAndPasswordQuery\FindUserByEmailAndPasswordQueryHandler::class,
        \App\AuthContext\Application\User\Query\GetClientPasswordQuery\GetClientPasswordQuery::class =>
            \App\AuthContext\Application\User\Query\GetClientPasswordQuery\GetClientPasswordQueryHandler::class,
    ],
];
