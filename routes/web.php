<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\backend\ReviewController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');

Route::get('/verify', [AdminController::class, 'showVerification'])->name('custom.verification.form');
Route::post('/verify', [AdminController::class, 'verificationVerify'])->name('custom.verification.verify');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'profileStore'])->name('profile.store');
    Route::post('/admin/password/update', [AdminController::class, 'passwordUpdate'])->name('admin.password.update');
});

Route::middleware('auth')->group(function () {
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/all/review', 'allReview')->name('all.review');
        Route::get('/add/review', 'addReview')->name('add.review');
        Route::post('/store/review', 'storeReview')->name('store.review');
        Route::get('/edit/review/{id}', 'editReview')->name('edit.review');
        Route::post('/update/review/{id}', 'updateReview')->name('update.review');
        Route::get('/delete/review/{id}', 'deleteReview')->name('delete.review');
    });

    Route::controller(SliderController::class)->group(function () {
        Route::get('/get/slider', 'getSlider')->name('get.slider');
        Route::post('/update/slider', 'updateSlider')->name('update.slider');
        Route::post('/edit-slider/{id}', 'editSlider')->name('edit.slider');
        Route::post('/edit-features/{id}', 'editFeatures')->name('edit.features');
        Route::post('/edit-reviews/{id}', 'editReviews')->name('edit.reviews');
        Route::post('/edit-answers/{id}', 'editAnswers')->name('edit.answers');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/all/feature', 'allFeature')->name('all.feature');
        Route::get('/add/feature', 'addFeature')->name('add.feature');
        Route::post('/store/feature', 'storeFeature')->name('store.feature');
        Route::get('/edit/feature/{id}', 'editFeature')->name('edit.feature');
        Route::post('/update/feature/{id}', 'updateFeature')->name('update.feature');
        Route::get('/delete/feature/{id}', 'deleteFeature')->name('delete.feature');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/get/clarifies', 'getClarifies')->name('get.clarifies');
        Route::post('/update/clarifies', 'updateClarifies')->name('update.clarifies');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/get/financials', 'getFinancials')->name('get.financials');
        Route::post('/update/financials', 'updateFinancials')->name('update.financials');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/get/usabilities', 'getUsabilities')->name('get.usabilities');
        Route::post('/update/usabilities', 'updateUsabilities')->name('update.usabilities');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/all/connect', 'allConnect')->name('all.connect');
        Route::get('/add/connect', 'addConnect')->name('add.connect');
        Route::post('/store/connect', 'storeConnect')->name('store.connect');
        Route::get('/edit/connect/{id}', 'editConnect')->name('edit.connect');
        Route::post('/update/connect/{id}', 'updateConnect')->name('update.connect');
        Route::get('/delete/connect/{id}', 'deleteConnect')->name('delete.connect');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::get('/all/faq', 'allFaq')->name('all.faqs');
        Route::get('/add/faq', 'addFaq')->name('add.faq');
        Route::post('/store/faq', 'storeFaq')->name('store.faq');
        Route::get('/edit/faq/{id}', 'editFaq')->name('edit.faq');
        Route::post('/update/faq/{id}', 'updateFaq')->name('update.faq');
        Route::get('/delete/faq/{id}', 'deleteFaq')->name('delete.faq');
    });

    Route::controller(HomeController::class)->group(function () {
        Route::post('/update-app/{id}', 'updateApp')->name('update.app');
        Route::post('/update-app-image/{id}', 'updateAppImage')->name('update.app.image');
    });
});

