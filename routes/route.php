<?php

use App\Services\Route;

Route::add("/", "HomeController", "index", "GET");
Route::add("login", "UsersController", "index", "GET");
