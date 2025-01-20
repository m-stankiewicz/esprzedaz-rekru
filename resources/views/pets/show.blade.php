@extends('layouts.app')

@section('title', $pet['name'])

@section('content')
<h1 class="text-2xl font-bold">{{ $pet['name'] }}</h1>
<p>Status: {{ $pet['status'] }}</p>

<a href="{{ route('pets.index') }}" class="text-blue-500">Back to List</a>

<form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" class="mt-4">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-500">Delete</button>
</form>

<form action="{{ route('pets.update', $pet['id']) }}" method="POST" class="mt-4">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium">Name</label>
        <input type="text" name="name" id="name" value="{{ $pet['name'] }}" class="border rounded w-full px-2 py-1">
    </div>
    <div class="mb-4">
        <label for="status" class="block text-sm font-medium">Status</label>
        <select name="status" id="status" class="border rounded w-full px-2 py-1">
            @foreach(App\Enums\PetStatus::values() as $status)
                <option value="{{ $status }}" {{ $pet['status'] == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="text-blue-500">Update</button>
</form>
@endsection