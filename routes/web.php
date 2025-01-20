<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PetController;

Route::redirect('/', '/pets');
Route::resource('pets', PetController::class);

