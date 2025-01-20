<?php

namespace App\Services;

use App\Exceptions\InvalidIdException;
use App\Exceptions\PetNotFoundException;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Http;

class PetService
{
    private string $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.petstore.api_url', 'https://petstore.swagger.io/v2');
    }

    private function handleResponse($response)
    {
        if ($response->failed()) {
            $this->throwException($response);
        }

        return $response->json();
    }

    private function throwException($response)
    {
        $statusCode = $response->status();
        $message = $response->json('message', 'An error occurred');

        match ($statusCode) {
            400 => throw new InvalidIdException($message),
            404 => throw new PetNotFoundException($message),
            405 => throw new ValidationException($message),
            default => throw new \Exception($message, $statusCode),
        };
    }

    public function getPetsByStatus(array $statuses): array
    {
        $response = Http::withOptions(['verify' => false])
            ->get("{$this->baseUri}/pet/findByStatus", [
                'status' => implode(',', $statuses),
            ]);

        return $this->handleResponse($response);
    }

    public function getPetById(int $id): array
    {
        $response = Http::withOptions(['verify' => false])
            ->get("{$this->baseUri}/pet/{$id}");

        return $this->handleResponse($response);
    }

    public function createPet(array $payload): array
    {
        $response = Http::withOptions(['verify' => false])
            ->post("{$this->baseUri}/pet", $payload);

        return $this->handleResponse($response);
    }

    public function updatePet(int $id, array $payload): array
    {
        $response = Http::withOptions(['verify' => false])
            ->put("{$this->baseUri}/pet", array_merge(['id' => $id], $payload));

        return $this->handleResponse($response);
    }

    public function deletePet(int $id): void
    {
        $response = Http::withOptions(['verify' => false])
            ->delete("{$this->baseUri}/pet/{$id}");

        $this->handleResponse($response);
    }
}
