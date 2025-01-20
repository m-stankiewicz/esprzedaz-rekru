@extends('layouts.app')

@section('title', 'Pets')

@section('content')
<h1 class="text-2xl font-bold">Pets List</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
    @foreach($pets as $pet)
    <div class="border rounded p-4 shadow">
        <h2 class="text-lg font-bold">{{ isset($pet['name']) ? $pet['name'] : null  }}</h2>
        <p>Status: {{ $pet['status'] }}</p>
        <a href="{{ route('pets.show', $pet['id']) }}" class="text-blue-500">Details</a>
    </div>
    @endforeach
</div>
@endsection
