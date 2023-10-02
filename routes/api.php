<?php

use App\Utils\Response;
use Illuminate\Support\Facades\Route;

Route::get('healthy', function () {
    return Response::success('OK');
});
