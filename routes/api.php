<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\InventoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [AuthController::class, 'login']); //Route proses login
Route::middleware('auth:sanctum')->get('profile', [AuthController::class, 'getProfile']); //Route proses get profil yang sudah login
Route::middleware('auth:sanctum')->post('profile/update', [AuthController::class, 'updateProfile']); //Route proses update profile

Route::middleware('auth:sanctum')->post('inventory/add', [InventoryController::class, 'addInventory']); //Route proses Tambah inventory
Route::middleware('auth:sanctum')->put('inventory/update/{id}', [InventoryController::class, 'updateInventory']); //Route proses Update inventory
Route::middleware('auth:sanctum')->delete('inventory/delete/{id}', [InventoryController::class, 'deleteInventory']); //Route proses Hapus inventory
Route::middleware('auth:sanctum')->get('inventory/list', [InventoryController::class, 'listInventories']); //Route proses List Inventory
Route::middleware('auth:sanctum')->get('inventory/{id}', [InventoryController::class, 'getInventoryById']);//Route proses menampilkan data dengan ID

Route::post('users', [UserController::class, 'store']);
