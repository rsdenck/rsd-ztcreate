<?php

use App\Http\Controllers\WizardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WizardController::class, 'index'])->name('wizard.index');

Route::prefix('wizard')->name('wizard.')->group(function () {
    Route::post('/step1', [WizardController::class, 'step1'])->name('step1');
    
    Route::get('/step2', [WizardController::class, 'showStep2'])->name('step2');
    Route::post('/step2', [WizardController::class, 'step2'])->name('step2.post');
    
    Route::get('/step3', [WizardController::class, 'showStep3'])->name('step3');
    Route::post('/step3', [WizardController::class, 'step3'])->name('step3.post');
    
    Route::get('/step4', [WizardController::class, 'showStep4'])->name('step4');
    Route::post('/step4', [WizardController::class, 'step4'])->name('step4.post');
    
    Route::get('/step5', [WizardController::class, 'showStep5'])->name('step5');
    Route::post('/step5', [WizardController::class, 'step5'])->name('step5.post');
    
    Route::get('/finish', [WizardController::class, 'finish'])->name('finish');
    Route::post('/export', [WizardController::class, 'export'])->name('export');
});
