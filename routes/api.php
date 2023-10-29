<?php

use App\Http\Controllers\Api\ElectronicReceiptsController;
use App\Http\Controllers\Api\SignController;
use App\Http\Controllers\Api\XmlToJsonController;
use App\Http\Controllers\Controller;
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

// Route::middleware('auth:sanctum')
//     ->group(function () {
//     });

Route::post('receipt-electronic/generate-template-xml', [ElectronicReceiptsController::class, 'generateTemplateXml']);
Route::post('receipt-electronic/auth-electronioc-receipt', [ElectronicReceiptsController::class, 'authElectronicReceipt']);

Route::post('upload-sign-file', [SignController::class, 'uploadSignFile']);

Route::post('xml-to-json', [XmlToJsonController::class, 'xmlToJson']);
