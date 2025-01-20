<?php

namespace Tests\Feature;

use App\Services\PetService;
use App\Enums\PetStatus;
use App\Exceptions\InvalidIdException;
use App\Exceptions\PetNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;

    private PetService $mockPetService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockPetService = $this->createMock(PetService::class);
        $this->app->instance(PetService::class, $this->mockPetService);
    }

    public function testIndexReturnsPetsWithDefaultStatus()
    {
        $this->mockPetService->expects($this->once())
            ->method('getPetsByStatus')
            ->with([PetStatus::AVAILABLE->value])
            ->willReturn([['id' => 1, 'name' => 'Buddy', 'status' => PetStatus::AVAILABLE->value]]);

        $response = $this->get(route('pets.index'));

        $response->assertStatus(200);
        $response->assertViewHas('pets', [
            ['id' => 1, 'name' => 'Buddy', 'status' => PetStatus::AVAILABLE->value]
        ]);
    }

    public function testStoreCreatesPet()
    {
        $payload = ['name' => 'Buddy', 'status' => PetStatus::AVAILABLE->value];
        $this->mockPetService->expects($this->once())
            ->method('createPet')
            ->with($this->callback(function ($data) use ($payload) {
                return $data['name'] === $payload['name'] && $data['status'] === $payload['status'];
            }))
            ->willReturn(['id' => 1234, 'name' => 'Buddy', 'status' => PetStatus::AVAILABLE->value]);

        $response = $this->post(route('pets.store'), $payload);

        $response->assertRedirect(route('pets.index'));
        $response->assertSessionHas('success', 'Created a new pet with ID: 1234');
    }

    public function testShowReturnsPetDetails()
    {
        $this->mockPetService->expects($this->once())
            ->method('getPetById')
            ->with(1)
            ->willReturn(['id' => 1, 'name' => 'Buddy', 'status' => PetStatus::AVAILABLE->value]);

        $response = $this->get(route('pets.show', 1));

        $response->assertStatus(200);
        $response->assertViewHas('pet', [
            'id' => 1,
            'name' => 'Buddy',
            'status' => PetStatus::AVAILABLE->value,
        ]);
    }

    public function testShowHandlesPetNotFoundException()
    {
        $this->mockPetService->expects($this->once())
            ->method('getPetById')
            ->with(999)
            ->willThrowException(new PetNotFoundException('Pet not found'));

        $response = $this->get(route('pets.show', 999));

        $response->assertRedirect(route('pets.index'));
        $response->assertSessionHas('error', 'Pet not found');
    }

    public function testDestroyDeletesPet()
    {
        $this->mockPetService->expects($this->once())
            ->method('deletePet')
            ->with(1);

        $response = $this->delete(route('pets.destroy', 1));

        $response->assertRedirect(route('pets.index'));
        $response->assertSessionHas('success', 'Deleted pet with ID: 1');
    }

    public function testDestroyHandlesInvalidIdException()
    {
        $this->mockPetService->expects($this->once())
            ->method('deletePet')
            ->with(999)
            ->willThrowException(new InvalidIdException('Invalid ID'));

        $response = $this->delete(route('pets.destroy', 999));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Invalid ID');
    }
}
