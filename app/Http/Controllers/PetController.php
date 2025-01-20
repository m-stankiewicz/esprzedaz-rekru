<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidIdException;
use App\Exceptions\PetNotFoundException;
use App\Exceptions\ValidationException;
use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Services\PetService;
use App\Enums\PetStatus;
use Illuminate\Http\Request;

class PetController extends Controller
{
    private PetService $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index(Request $request)
    {
        try {
            $selectedStatuses = array_intersect(
                (array) $request->input('status', []),
                PetStatus::values()
            ) ?: [PetStatus::AVAILABLE->value];

            $pets = $this->petService->getPetsByStatus($selectedStatuses);

            return view('pets.index', compact('pets', 'selectedStatuses'));
        } catch (ValidationException $e) {
            return back()->with('error', 'Validation error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Error fetching pets: ' . $e->getMessage());
        }
    }

    public function store(StorePetRequest $request)
    {
        try {
            $payload = $request->validated();
            $payload['id'] = rand(1000, 999999);

            $pet = $this->petService->createPet($payload);

            return redirect()
                ->route('pets.index')
                ->with('success', "Created a new pet with ID: {$pet['id']}");
        } catch (ValidationException $e) {
            return back()->with('error', 'Validation error: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating pet: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $pet = $this->petService->getPetById($id);

            return view('pets.show', compact('pet'));
        } catch (InvalidIdException | PetNotFoundException $e) {
            return redirect()->route('pets.index')
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('pets.index')
                ->with('error', 'Error fetching pet details: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->petService->deletePet($id);

            return redirect()
                ->route('pets.index')
                ->with('success', "Deleted pet with ID: {$id}");
        } catch (InvalidIdException | PetNotFoundException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting pet: ' . $e->getMessage());
        }
    }

    public function update(UpdatePetRequest $request, $id)
{
    try {
        $payload = $request->validated();

        $pet = $this->petService->updatePet($id, $payload);

        return redirect()
            ->route('pets.show', $id)
            ->with('success', "Updated pet with ID: {$pet['id']} successfully.");
    } catch (InvalidIdException | PetNotFoundException $e) {
        return redirect()
            ->route('pets.index')
            ->with('error', $e->getMessage());
    } catch (ValidationException $e) {
        return back()
            ->with('error', 'Validation error: ' . $e->getMessage());
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Error updating pet: ' . $e->getMessage());
    }
}
}
