<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'returnDashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {   
    // Dashboard Email Actions
        Route::get('/email-reminder/archive/{id}',[EmailController::class, 'archiveEmailReminder']);
        Route::get('/email-reminder/unarchive/{id}',[EmailController::class, 'unarchiveEmailReminder']);
        Route::get('/email-reminder/delete/{id}',[EmailController::class, 'deleteEmailReminder']);
        Route::get('/email-reminder/snooze/{id}',[EmailController::class, 'snoozeEmailReminder']);
        Route::get('/email-reminder/{id}',[EmailController::class, 'viewEmailReminder']);
        Route::get('/email-reminder/edit/{id}',[EmailController::class, 'editEmailReminder']);
        Route::get('/email-reminder/reminder-confirmations/{id}',[EmailController::class, 'toggleReminderConfirmations']);
        Route::get('/email-reminder/reminders/{id}',[EmailController::class, 'toggleReminders']);
    });

    /**
     * Todo: stop users from deleting other user's emails. 
     */

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Profile Routes
Route::middleware('auth')->group(function () {
    Route::post('/new-email', [ProfileController::class, 'addEmail'])->name('profile.addemail');
    Route::get('/delete-email-account/{userEmail:id}', [ProfileController::class, 'deleteEmail']);
});


// EmailParsing Routes
Route::POST('/email-reminders/receive', [EmailController::class, 'receiveEmailsFromSendGrid']);

//Random
Route::get('/test',[DashboardController::class , 'showAllReminders']);

require __DIR__.'/auth.php';
