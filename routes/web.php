<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SessionController as AdminSessionController;
use App\Http\Controllers\Admin\SpeakerController as AdminSpeakerController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InfoController;
use App\Http\Controllers\Public\MapController;
use App\Http\Controllers\Public\MyTalksController;
use App\Http\Controllers\Public\ScheduleController;
use App\Http\Controllers\Public\SpeakerController as PublicSpeakerController;
use App\Http\Controllers\Public\TalkController;
use Illuminate\Support\Facades\Route;

// Auth placeholder
Route::inertia('/login', 'Auth/Login')->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/my-talks');
    }

    return back()->withErrors([
        'email' => 'Las credenciales no son correctas.',
    ])->onlyInput('email');
});

// Register
Route::inertia('/register', 'Auth/Register')->name('register');

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:8', 'confirmed'],
    ]);

    $user = \App\Domain\Users\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
    ]);

    \Illuminate\Support\Facades\Auth::login($user);
    $request->session()->regenerate();

    return redirect('/my-talks');
});

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
})->name('logout');
// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/talks', [TalkController::class, 'index'])->name('talks.index');
Route::get('/talks/{id}', [TalkController::class, 'show'])->name('talks.show');
Route::get('/speakers', [PublicSpeakerController::class, 'index'])->name('speakers.index');
Route::get('/speakers/{id}', [PublicSpeakerController::class, 'show'])->name('speakers.show');

// Schedule
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

// My Talks (agenda personal)
Route::get('/my-talks', [MyTalksController::class, 'index'])->name('my-talks.index')->middleware('auth');
Route::post('/my-talks/{sessionId}', [MyTalksController::class, 'store'])->name('my-talks.store')->middleware('auth');
Route::delete('/my-talks/{sessionId}', [MyTalksController::class, 'destroy'])->name('my-talks.destroy')->middleware('auth');

// Map (salas)
Route::get('/map', [MapController::class, 'index'])->name('map.index');
Route::get('/map/{id}', [MapController::class, 'show'])->name('map.show');

// Info
Route::get('/info', [InfoController::class, 'index'])->name('info.index');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('events/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::resource('speakers', AdminSpeakerController::class)->except(['show']);
    Route::resource('sessions', AdminSessionController::class)->except(['show']);
    Route::resource('rooms', RoomController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
});
