<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AcademicsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\ExperienceController;

Route::get('php-artisan', function () {

    Artisan::call('storage:link');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    // Call route:list and get the output
    Artisan::call('route:list');
    $routeList = Artisan::output();

    // Return the route list as a response
    return response($routeList);
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('users-all/{userName}', [UserController::class, 'showAll']);
Route::get('reset-theme-all-users', [UserController::class, 'updateThemeForAllUsers']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::middleware('auth:sanctum')->group(function () {

    // UserController routes
    Route::controller(UserController::class)->group(function () {
        Route::post('users', 'store');
        Route::get('users', 'index');
        Route::get('users/{id}', 'show');
        Route::put('users/{id}', 'update');
        Route::put('users-theme/{id}', 'usersTheme');
        Route::post('users/delete', 'destroy');
    });
    Route::controller(PhotoController::class)->group(function () {
        // Route::post('photo', 'store');
        // Route::get('photo', 'index');
        // Route::get('photo/{id}', 'show');
        // Route::put('photo/{id}', 'update');
        Route::delete('photo/{id}', 'destroy');
    });

    // AcademicsController routes
    Route::controller(AcademicsController::class)->group(function () {
        Route::post('academics', 'store');
        Route::get('academics', 'index');
        Route::get('academics/{id}', 'show');
        Route::put('academics/{id}', 'update');
        Route::post('academics/delete', 'destroy');
    });

    // ContactController routes
    Route::controller(ContactController::class)->group(function () {
        Route::post('contacts', 'store');
        Route::get('contacts', 'index');
        Route::get('contacts-unread', 'getUnreadContactsCount');
        Route::get('contacts-mark-all-read', 'markAllAsUnread');
        Route::get('contacts/{id}', 'show');
        Route::put('contacts/{id}', 'update');
        Route::post('contacts/delete', 'destroy');
    });

    // CredentialController routes
    Route::controller(CredentialController::class)->group(function () {
        Route::post('credentials', 'store');
        Route::get('credentials', 'index');
        Route::get('credentials/{id}', 'show');
        Route::put('credentials/{id}', 'update');
        Route::post('credentials/delete', 'destroy');
    });

    // ExperienceController routes
    Route::controller(ExperienceController::class)->group(function () {
        Route::post('experiences', 'store');
        Route::get('experiences', 'index');
        Route::get('experiences/{id}', 'show');
        Route::put('experiences/{id}', 'update');
        Route::post('experiences/delete', 'destroy');
    });

    // LanguageController routes
    Route::controller(LanguageController::class)->group(function () {
        Route::post('languages', 'store');
        Route::get('languages', 'index');
        Route::get('languages/{id}', 'show');
        Route::put('languages/{id}', 'update');
        Route::post('languages/delete', 'destroy');
    });

    // ProjectController routes
    Route::controller(ProjectController::class)->group(function () {
        Route::post('projects', 'store');
        Route::get('projects', 'index');
        Route::get('projects/{id}', 'show');
        Route::put('projects/{id}', 'update');
        Route::post('projects/delete', 'destroy');
    });

    // SkillController routes
    Route::controller(SkillController::class)->group(function () {
        Route::post('skills', 'store');
        Route::get('skills', 'index');
        Route::get('skills/{id}', 'show');
        Route::put('skills/{id}', 'update');
        Route::post('skills/delete', 'destroy');
    });

    // SocialController routes
    Route::controller(SocialController::class)->group(function () {
        Route::post('socials', 'store');
        Route::get('socials', 'index');
        Route::get('socials/{id}', 'show');
        Route::put('socials/{id}', 'update');
        Route::post('socials/delete', 'destroy');
    });

    // ThemeController routes
    Route::controller(ThemeController::class)->group(function () {
        Route::post('themes', 'store');
        Route::get('themes', 'index');
        Route::get('themes/{id}', 'show');
        Route::put('themes/{id}', 'update');
        Route::post('themes/delete', 'destroy');
    });
});
