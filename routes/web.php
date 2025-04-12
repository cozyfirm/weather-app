<?php

use App\Http\Controllers\Admin\Base\BaseCitiesController;
use App\Http\Controllers\Admin\Core\KeywordsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Other\FAQsController;
use App\Http\Controllers\Admin\Other\SinglePagesController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\PublicPart\ContactController;
use App\Http\Controllers\PublicPart\ForecastController;
use App\Http\Controllers\PublicPart\HomeController as PublicHomeController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    /**
     *  Public part of Web App
     */
    Route::get ('/',                              [PublicHomeController::class, 'home'])->name('public.home');

    /**
     *  Forecast routes
     */
    Route::prefix('/forecast')->group(function () {
        /** Display searched cities */
        Route::get ('/search/{keyword}',              [ForecastController::class, 'search'])->name('public.forecast.search');

        /** Get city by Ip Addr */
        Route::get ('/get-my-city',                   [ForecastController::class, 'getMyCity'])->name('public.forecast.get-my-city');

        /** Preview searched city */
        Route::get ('/preview/{cityKey}',                        [ForecastController::class, 'preview'])->name('public.forecast.preview');
        Route::get ('/preview-day/{cityKey}/{date}/{type}',      [ForecastController::class, 'previewDay'])->name('public.forecast.preview-day');

        /**
         *  API Routes
         */
        Route::prefix('/api-routes')->group(function () {
            Route::post('/search-by-text',            [ForecastController::class, 'searchByText'])->name('public.forecast.api-routes.search-by-text');
        });
    });

    Route::prefix('/contact-us')->group(function () {
        Route::get ('/',                        [ContactController::class, 'home'])->name('public.contact-us');
        Route::post('/send-a-message',          [ContactController::class, 'sendMessage'])->name('public.contact-us.send-a-message');
    });

    Route::prefix('/pages')->group(function () {
        Route::get ('/privacy-policy',                 [PublicHomeController::class, 'privacyPolicy'])->name('public.pages.privacy-policy');
        Route::get ('/terms-and-conditions',           [PublicHomeController::class, 'terms'])->name('public.pages.terms-and-conditions');
        Route::get ('/cookies',                        [PublicHomeController::class, 'cookies'])->name('public.pages.cookies');

        Route::get ('/effects/{type}',                 [PublicHomeController::class, 'effects'])->name('public.pages.effects');
    });
});

/**
 *  Auth routes
 */

Route::prefix('auth')->group(function () {
    Route::get ('/',                              [AuthController::class, 'auth'])->name('auth');
    Route::post('/authenticate',                  [AuthController::class, 'authenticate'])->name('auth.authenticate');
    Route::get ('/logout',                        [AuthController::class, 'logout'])->name('auth.logout');

    /* Create an account */
    Route::get ('/create-account',                [AuthController::class, 'createAccount'])->name('auth.create-account');
    Route::post('/save-account',                  [AuthController::class, 'saveAccount'])->name('auth.save-account');
    Route::get ('/verify-account/{token}',        [AuthController::class, 'verifyAccount'])->name('auth.verify-account');

    /* Restart password */
    Route::get ('/restart-password',              [AuthController::class, 'restartPassword'])->name('auth.restart-password');
    Route::post('/generate-restart-token',        [AuthController::class, 'generateRestartToken'])->name('auth.generate-restart-token');
    Route::get ('/new-password/{token}',          [AuthController::class, 'newPassword'])->name('auth.new-password');
    Route::post('/generate-new-password',         [AuthController::class, 'generateNewPassword'])->name('auth.generate-new-password');
});


/**
 *  Admin routes
 */

Route::prefix('system')->middleware('isLogged')->group(function () {
    Route::prefix('admin')->middleware('isAdmin')->group(function (){
        Route::get('/dashboard',                 [HomeController::class, 'index'])->name('system.home');

        /**
         *  Users routes;
         */
        Route::prefix('users')->group(function () {
            Route::get ('/',                          [UsersController::class, 'index'])->name('system.admin.users');
            Route::get ('/create',                    [UsersController::class, 'create'])->name('system.admin.users.create');
            Route::post('/save',                      [UsersController::class, 'save'])->name('system.admin.users.save');
            Route::get ('/preview/{username}',        [UsersController::class, 'preview'])->name('system.admin.users.preview');
            Route::get ('/edit/{username}',           [UsersController::class, 'edit'])->name('system.admin.users.edit');
            Route::post('/update',                    [UsersController::class, 'update'])->name('system.admin.users.update');
            Route::post('/update-profile-image',      [UsersController::class, 'updateProfileImage'])->name('system.admin.users.update-profile-image');
        });

        /**
         *  Other section
         *  1. FAQs
         */
        Route::prefix('other')->group(function () {
            /**
             *  FAQs section
             */
            Route::prefix('faq')->group(function () {
                Route::get ('/',                               [FAQsController::class, 'faqIndex'])->name('system.admin.other.faq');
                Route::get ('/create',                         [FAQsController::class, 'faqCreate'])->name('system.admin.other.faq.create');
                Route::post('/save',                           [FAQsController::class, 'faqSave'])->name('system.admin.other.faq.save');
                Route::get ('/edit/{id}',                      [FAQsController::class, 'faqEdit'])->name('system.admin.other.faq.edit');
                Route::post('/update',                         [FAQsController::class, 'faqUpdate'])->name('system.admin.other.faq.update');
                Route::get ('/delete/{id}',                    [FAQsController::class, 'faqDelete'])->name('system.admin.other.faq.delete');
            });

            Route::prefix('single-pages')->group(function () {
                Route::get ('/',                               [SinglePagesController::class, 'index'])->name('system.admin.other.single-pages');
                Route::get ('/edit/{id}',                      [SinglePagesController::class, 'edit'])->name('system.admin.other.single-pages.edit');
                Route::post('/update',                         [SinglePagesController::class, 'update'])->name('system.admin.other.single-pages.update');
            });
        });

        /**
         *  Core section:
         *  1. Keywords
         */
        Route::prefix('core')->group(function () {
            /**
             *  FAQs section
             */
            Route::prefix('keywords')->group(function () {
                Route::get ('/',                                    [KeywordsController::class, 'index'])->name('system.admin.core.keywords');
                Route::get ('/preview-instances/{key}',             [KeywordsController::class, 'previewInstances'])->name('system.admin.core.keywords.preview-instances');
                Route::get ('/new-instance/{key}',                  [KeywordsController::class, 'newInstance'])->name('system.admin.core.keywords.new-instance');

                Route::post('/save-instance',                       [KeywordsController::class, 'saveInstance'])->name('system.admin.core.keywords.save-instance');
                Route::get ('/edit-instance/{id}',                  [KeywordsController::class, 'editInstance'])->name('system.admin.core.keywords.edit-instance');
                Route::post('/update-instance',                     [KeywordsController::class, 'updateInstance'])->name('system.admin.core.keywords.update-instance');
                Route::get ('/delete-instance/{id}',                [KeywordsController::class, 'deleteInstance'])->name('system.admin.core.keywords.delete-instance');
            });
        });

        /**
         *  Blog:: ToDo
         */
        Route::prefix('blog')->group(function () {
            Route::get ('/',                               [AdminBlogController::class, 'index'])->name('system.admin.blog');
            Route::get ('/create',                         [AdminBlogController::class, 'create'])->name('system.admin.blog.create');
            Route::post('/save',                           [AdminBlogController::class, 'save'])->name('system.admin.blog.save');
            Route::get ('/preview/{id}',                   [AdminBlogController::class, 'preview'])->name('system.admin.blog.preview');
            Route::get ('/edit/{id}',                      [AdminBlogController::class, 'edit'])->name('system.admin.blog.edit');
            Route::post('/update',                         [AdminBlogController::class, 'update'])->name('system.admin.blog.update');
            Route::get ('/delete/{id}',                    [AdminBlogController::class, 'delete'])->name('system.admin.blog.delete');

            /*
             *  Work with images
             */
            Route::post('/add-to-gallery',                 [AdminBlogController::class, 'addToGallery'])->name('system.admin.blog.add-to-gallery');
            Route::get ('/delete-from-gallery/{id}',       [AdminBlogController::class, 'deleteFromGallery'])->name('system.admin.blog.delete-from-gallery');

            Route::get ('/edit-image/{id}/{what}',         [AdminBlogController::class, 'editImage'])->name('system.admin.blog.edit-image');
            Route::post('/update-image',                   [AdminBlogController::class, 'updateImage'])->name('system.admin.blog.update-image');
        });

        /** --------------------------------------------------------------------------------------------------------- */
        /**
         *  Base cities and places
         */

        Route::prefix('base')->middleware('isAdmin')->group(function () {
            Route::prefix('cities')->middleware('isAdmin')->group(function () {
                Route::get ('/',                          [BaseCitiesController::class, 'index'])->name('system.admin.base.cities');
                Route::get ('/create',                    [BaseCitiesController::class, 'create'])->name('system.admin.base.cities.create');
                Route::post('/save',                      [BaseCitiesController::class, 'save'])->name('system.admin.base.cities.save');
                Route::get ('/preview/{id}',              [BaseCitiesController::class, 'preview'])->name('system.admin.base.cities.preview');
                Route::get ('/edit/{id}',                 [BaseCitiesController::class, 'edit'])->name('system.admin.base.cities.edit');
                Route::post('/update',                    [BaseCitiesController::class, 'update'])->name('system.admin.base.cities.update');
                Route::get ('/delete/{id}',               [BaseCitiesController::class, 'delete'])->name('system.admin.base.cities.delete');

                /* Fetch from API */
                Route::post('/fetch',                     [BaseCitiesController::class, 'fetch'])->name('system.admin.base.cities.fetch');
            });
        });
    });
});
