<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::apiResource('members', MemberController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('members', MemberController::class);
    Route::apiResource('loans', LoanController::class);
    Route::apiResource('repayments', RepaymentController::class);
});