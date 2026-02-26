<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/logine', function(){
    return response()->json([
        'success' => false,
        'message' => 'Veillez vous connecter'
    ],403);
})->name('logine');

Route::post('/login', [AdminController::class, 'login']);
// routes/api.php

Route::middleware('auth:admin')->group(function () {
    Route::get('/info/admin', [AdminController::class, 'info_admin']);
    Route::post('/ajout/admin', [AdminController::class, 'ajout_admin']);
    Route::get('/admins', [AdminController::class, 'admins']);
    Route::get('/admin/{id}', [AdminController::class, 'admin']);
    Route::post('/delete/admin/{id}', [AdminController::class, 'delete_admin']);
    Route::post('/update/profil/admin', [AdminController::class, 'update_profil_admin']);
    Route::post('/change/password', [AdminController::class, 'change_password']);
    Route::get('/entreprises', [AdminController::class, 'entreprises']);
    Route::get('/entreprise/{id}', [AdminController::class, 'entreprise']);
    Route::get('/solde/entreprise', [AdminController::class, 'solde_entreprise']);
    Route::get('/solde/admin', [AdminController::class, 'solde_admin']);
    Route::post('/delete/entreprise/{id}', [AdminController::class, 'delete_entreprise']);
    Route::post('/reset/password/{id}', [AdminController::class, 'renitialiser_mot_passe']);
});
