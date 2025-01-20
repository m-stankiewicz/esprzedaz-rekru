@extends('layouts.app')

@section('title', isset($pet) ? 'Edit Pet' : 'Create Pet')

@section('content')
<h1 class="text-2xl font-bold">{{ isset($pet) ? 'Edit Pet' : 'Create New Pet' }}</h1>
<form action="{{ isset($pet) ? route('pets.update', $pet['id']) : route('pets.store') }}" method="POST" class="mt-4">
    @csrf
    @if(isset($pet))
        @method('PUT')
    @endif

    <div class="mb-4">
        <label for="name" class="block text-sm font-bold">Name</label>
        <input type="text" id="name" name="name" value="{{ $pet['name'] ?? old('name') }}" required class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label for="status" class="block text-sm font-bold">Status</label>
        <select id="status" name="status" class="w-full border rounded p-2" required>
            @foreach(App\Enums\PetStatus::values() as $status)
                <option value="{{ $status }}" {{ (isset($pet) && $pet['status'] === $status) ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4">
        {{ isset($pet) ? 'Update' : 'Create' }}
    </button>
</form>
@endsection
