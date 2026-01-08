<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\AnimeDetail;
use App\Livewire\Public\Trending;
use App\Livewire\Public\Catalog;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Livewire\User\Profile as UserProfile;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Anime\Index as AnimeIndex;
use App\Livewire\Admin\Anime\Create as AnimeCreate;
use App\Livewire\Admin\Anime\Edit as AnimeEdit;
use App\Livewire\Admin\Episode\Index as EpisodeIndex;
use App\Livewire\Admin\Episode\Create as EpisodeCreate;
use App\Livewire\Admin\Episode\Edit as EpisodeEdit;
use App\Livewire\Admin\Genre\Index as GenreIndex;
use App\Livewire\Admin\Genre\Create as GenreCreate;
use App\Livewire\Admin\Genre\Edit as GenreEdit;
use App\Livewire\Admin\Studio\Index as StudioIndex;
use App\Livewire\Admin\Studio\Create as StudioCreate;
use App\Livewire\Admin\Studio\Edit as StudioEdit;
use App\Livewire\Admin\User\Index as UserIndex;

// PUBLIC ROUTES
Route::view('/', 'welcome')->name('home'); // KEMBALI KE WELCOME.BLADE.PHP
Route::get('/trending', Trending::class)->name('trending');
Route::get('/catalog', Catalog::class)->name('catalog');
Route::get('/anime/{slug}', AnimeDetail::class)->name('anime.detail');
Route::post('/payment/notification', [App\Http\Controllers\PaymentController::class, 'notification'])->name('payment.notification');
Route::post('/logout', function () {
    Illuminate\Support\Facades\Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

// USER ROUTES
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', UserDashboard::class)->name('dashboard');
    Route::get('/profile', UserProfile::class)->name('profile');
    Route::get('/watchlist', \App\Livewire\User\Watchlist::class)->name('watchlist');
    Route::get('/subscription', \App\Livewire\User\Subscription::class)->name('subscription');
});

// ADMIN ROUTES
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

    // Anime CRUD
    Route::prefix('anime')->name('anime.')->group(function () {
        Route::get('/', AnimeIndex::class)->name('index');
        Route::get('/create', AnimeCreate::class)->name('create');
        Route::get('/{anime}/edit', AnimeEdit::class)->name('edit');

        // Episodes (Nested)
        Route::prefix('{anime}/episodes')->name('episodes.')->group(function () {
            Route::get('/', EpisodeIndex::class)->name('index');
            Route::get('/create', EpisodeCreate::class)->name('create');
            Route::get('/{episode}/edit', EpisodeEdit::class)->name('edit');
        });
    });

    // Genre CRUD
    Route::prefix('genres')->name('genres.')->group(function () {
        Route::get('/', GenreIndex::class)->name('index');
        Route::get('/create', GenreCreate::class)->name('create');
        Route::get('/{genre}/edit', GenreEdit::class)->name('edit');
    });

    // Studio CRUD
    Route::prefix('studios')->name('studios.')->group(function () {
        Route::get('/', StudioIndex::class)->name('index');
        Route::get('/create', StudioCreate::class)->name('create');
        Route::get('/{studio}/edit', StudioEdit::class)->name('edit');
    });

    // Users CRUD
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', UserIndex::class)->name('index');
    });

    // Landing Page Settings
    Route::get('/settings/hero', \App\Livewire\Admin\Settings\HeroSettings::class)->name('settings.hero');
    Route::get('/settings/general', \App\Livewire\Admin\Settings\General::class)->name('settings.general');
    Route::get('/settings/ads', \App\Livewire\Admin\Settings\Ads::class)->name('settings.ads');
});

require __DIR__.'/auth.php';
