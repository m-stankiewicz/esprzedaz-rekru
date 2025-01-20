<?php

namespace Tests\Unit;

use App\Services\PetService;
use App\Exceptions\InvalidIdException;
use App\Exceptions\PetNotFoundException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PetServiceTest extends TestCase
{
    private PetService $petService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->petService = new PetService();
    }

    public function testGetPetsByStatusReturnsPets()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/findByStatus*' => Http::response([
                ['id' => 1, 'name' => 'Buddy', 'status' => 'available']
            ], 200),
        ]);

        $pets = $this->petService->getPetsByStatus(['available']);

        $this->assertEquals([
            ['id' => 1, 'name' => 'Buddy', 'status' => 'available']
        ], $pets);
    }

    public function testGetPetByIdThrowsNotFoundException()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/999' => Http::response(['message' => 'Pet not found'], 404),
        ]);

        $this->expectException(PetNotFoundException::class);
        $this->petService->getPetById(999);
    }

    public function testCreatePetReturnsCreatedPet()
    {
        $payload = ['name' => 'Buddy', 'status' => 'available'];

        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response([
                'id' => 1234,
                'name' => 'Buddy',
                'status' => 'available'
            ], 200),
        ]);

        $pet = $this->petService->createPet($payload);

        $this->assertEquals([
            'id' => 1234,
            'name' => 'Buddy',
            'status' => 'available'
        ], $pet);
    }

    public function testUpdatePetUpdatesAndReturnsPet()
    {
        $payload = ['name' => 'Buddy Updated', 'status' => 'sold'];

        Http::fake([
            'https://petstore.swagger.io/v2/pet' => Http::response([
                'id' => 1234,
                'name' => 'Buddy Updated',
                'status' => 'sold'
            ], 200),
        ]);

        $pet = $this->petService->updatePet(1234, $payload);

        $this->assertEquals([
            'id' => 1234,
            'name' => 'Buddy Updated',
            'status' => 'sold'
        ], $pet);
    }

    public function testDeletePetHandlesSuccess()
    {
        Http::fake([
            'https://petstore.swagger.io/v2/pet/1234' => Http::response([], 200),
        ]);

        $this->petService->deletePet(1234);

        $this->assertTrue(true); // Jeśli nie było wyjątku, test przeszedł
    }
}
