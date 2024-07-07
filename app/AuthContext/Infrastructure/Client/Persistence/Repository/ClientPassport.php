<?php

declare (strict_types=1);

namespace App\AuthContext\Infrastructure\Client\Persistence\Repository;

use App\AuthContext\Domain\Client\ClientInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientPassport implements ClientInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getClient(): array
    {
        $client = Client::where('password_client', 1)->first();

        if (!$client) {
            throw new NotFoundHttpException('Password grant client not found.');
        }

        return [
            'client_id' => $client->id,
            'client_secret' => $client->secret,
        ];
    }

    public function createGrantPasswordToken(string $clientId, string $clientSecret, string $email, string $password): array
    {
        $this->request->request->add([
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $email,
            'password' => $password,
            'scope' => '',
        ]);

        $tokenRequest = Request::create('/oauth/token', 'POST');

        $response = Route::dispatch($tokenRequest);

        return json_decode($response->getContent(), true);
    }
}