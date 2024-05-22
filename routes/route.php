<?php

use App\Services\Route;

// Define routes
Route::get("/", "HomeController", "index");
Route::get("login", "UsersController", "index");
Route::post("login", "UsersController", "login");

// Middleware group for routes that require authentication
// Route::group(['App\Middleware\AuthMiddleware'], function () {
//     Route::get("dashboard", "DashboardController", "index");
//     Route::get("profile", "ProfileController", "index");
//     Route::get("settings", "SettingsController", "index");
// });
