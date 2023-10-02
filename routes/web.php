<?php

use App\Utils\Response;
use Illuminate\Support\Facades\Route;

Route::any('{any}', function () {
    return Response::unauthorized();
})->where('any', '.*');
