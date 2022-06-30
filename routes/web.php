<?php
    use App\Services\Web\Route;
    use App\Controllers\HomeController;

    return [
        "/" => Route::get(HomeController::class, "index"),
        "/calculate-payout" => Route::post(HomeController::class, "calculatePayout"),
        "/download" => Route::get(HomeController::class, "download")
    ];
