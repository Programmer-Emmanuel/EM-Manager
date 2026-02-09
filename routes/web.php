<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\EntrepriseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::get('/services', [AccueilController::class, 'service'])->name('service');
Route::get('/apropos',[AccueilController::class, 'apropos'])->name('apropos');
Route::get('/contacts',[AccueilController::class, 'contact'])->name('contact');

Route::get('/login',[EntrepriseController::class, 'login'])->name('login');
Route::post('/login',[EntrepriseController::class, 'postLogin'])->name('postLogin');
Route::get('/register',[EntrepriseController::class, 'register'])->name('register');
Route::post('/register',[EntrepriseController::class, 'postRegister'])->name('postRegister');
Route::get('/logout',[EntrepriseController::class, 'logout'])->name('logout'); 

Route::get('/entreprise/dashboard',[EntrepriseController::class, 'dashboard_entreprise'])->name('dashboard_entreprise')->middleware('entreprise');
Route::get('/entreprise/liste/employe', [EntrepriseController::class, 'liste_employe'])->name('liste_employe')->middleware('entreprise');
Route::get('/employe/export', [EntrepriseController::class, 'export_employe'])->name('export_employe')->middleware('entreprise');
Route::get('/entreprise/ajout/employe', [EntrepriseController::class, 'ajout_employe'])->name('ajout_employe')->middleware('entreprise');
Route::post('/entreprise/store/employe', [EntrepriseController::class,'store_employe'])->name('store_employe')->middleware('entreprise');
Route::get('/entreprise/employe/{id}/edit', [EntrepriseController::class, 'edit_employe'])->name('edit_employe')->middleware('entreprise');
Route::put('/entreprise/employe/{id}', [EntrepriseController::class, 'update_employe'])->name('update_employe')->middleware('entreprise');
Route::delete('/entreprise/employe/{id}', [EntrepriseController::class, 'destroy_employe'])->name('destroy_employe')->middleware('entreprise');
Route::get('/entreprise/gestion/conge', [EntrepriseController::class,'gestion_conge'])->name('gestion_conge')->middleware('entreprise');
Route::patch('/conge/{id}/approuver', [EntrepriseController::class, 'approuver'])->name('conge_approuver')->middleware('entreprise');
Route::patch('/conge/{id}/rejeter', [EntrepriseController::class, 'rejeter'])->name('conge_rejeter')->middleware('entreprise');
Route::get('/entreprise/comptes', [EntrepriseController::class, 'comptes'])->name('comptes')->middleware('entreprise');
Route::get('/entreprise/transactions', [EntrepriseController::class, 'transactions'])->name('transactions')->middleware('entreprise');
Route::post('/entreprise/transactions', [EntrepriseController::class, 'transactionsPost'])->name('transactionsPost')->middleware('entreprise');
Route::get('/analyse/conseils', [EntrepriseController::class, 'afficherConseils'])->name('analyse_conseils')->middleware('entreprise');

Route::get('/entreprise/protected', [EntrepriseController::class, 'entreprise_protect'])->name('entreprise_protect');

Route::get('/employe/dashboard', [EmployeController::class, 'employe_dashboard'])->name('employe_dashboard')->middleware('employe');
Route::get('/employe/compte', [EmployeController::class, 'employe_compte'])->name('employe_compte')->middleware('employe');
Route::get('/employe/update/password', [EmployeController::class, 'update_password'])->name('update_password')->middleware('employe');
Route::put('/employe/update/password', [EmployeController::class, 'update_put_password'])->name('update_put_password')->middleware('employe');
Route::get('/employe/conge', [EmployeController::class, 'employe_conge'])->name('employe_conge')->middleware('employe');
Route::get('/employe/demande/conge', [EmployeController::class, 'demande_conge'])->name('demande_conge')->middleware('employe');
Route::post('/employe/demande/conge', [EmployeController::class, 'demande_conge_post'])->name('demande_conge_post')->middleware('employe');
Route::get('/employe/protected', [EmployeController::class, 'employe_protect'])->name('employe_protect');
Route::post('/chat-ai', [EntrepriseController::class, 'chat'])->name('chat.ai');

// Routes pour la gestion des produits
Route::middleware('entreprise')->group(function () {
    Route::get('/produits', [EntrepriseController::class, 'liste_produits'])->name('liste_produits');
    Route::get('/produits/ajouter', [EntrepriseController::class, 'ajout_produit'])->name('ajout_produit');
    Route::post('/produits/store', [EntrepriseController::class, 'store_produit'])->name('store_produit');
    Route::get('/produits/edit/{id}', [EntrepriseController::class, 'edit_produit'])->name('edit_produit');
    Route::post('/produits/update/{id}', [EntrepriseController::class, 'update_produit'])->name('update_produit');
    Route::delete('/produits/destroy/{id}', [EntrepriseController::class, 'destroy_produit'])->name('destroy_produit');
});

// Paiement des employés
Route::middleware('entreprise')->group(function () {
    Route::get('/paiement/employe', [EntrepriseController::class, 'paiement_employe'])->name('paiement.employe');
    Route::post('/process-paiement', [EntrepriseController::class, 'process_paiement'])->name('paiement.process');
    Route::get('/historique/paiements', [EntrepriseController::class, 'historique_paiements'])->name('paiement.historique');
});
Route::post('/paiement-callback', [EntrepriseController::class, 'paiement_callback'])->name('paiement.callback');
