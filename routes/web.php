<?php

use App\Http\Controllers\CspReportController;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

Route::post('/csp-report', CspReportController::class)
    ->withoutMiddleware([
        PreventRequestForgery::class,
        StartSession::class,
        ShareErrorsFromSession::class,
    ])
    ->middleware('throttle:300,1')
    ->name('csp.report');

Route::view('/', 'pages.home')->name('home');
Route::view('/privacy', 'pages.privacy')->name('privacy');

Route::view('/contact', 'pages.contact')->name('contact');

Route::redirect('/technology', '/#technology', 301);
Route::redirect('/about', '/#about', 301);
Route::redirect('/company/about', '/#about', 301);
Route::redirect('/company/contact', '/contact', 301);

Route::redirect('/solutions/loan-draw-inspections', '/#solutions', 301);
Route::redirect('/solutions/insurance-claims', '/#solutions', 301);
Route::redirect('/solutions/kyc-onboarding', '/#solutions', 301);
Route::redirect('/solutions/asset-verification', '/#solutions', 301);
Route::redirect('/solutions/banking', '/#solutions', 301);
Route::redirect('/solutions/insurance', '/#solutions', 301);
Route::redirect('/solutions/real-estate', '/#solutions', 301);
Route::redirect('/solutions/government', '/', 301);
Route::redirect('/solutions/ecommerce', '/', 301);
Route::redirect('/solutions/healthcare', '/', 301);

Route::redirect('/resources/injection-attacks', '/', 301);
Route::redirect('/resources/fraud-statistics', '/', 301);
Route::redirect('/resources/compliance', '/', 301);
Route::redirect('/resources/case-studies', '/', 301);

Route::permanentRedirect('/pricing', '/contact');
Route::permanentRedirect('/how-it-works', '/#technology');
Route::permanentRedirect('/enterprise', '/#solutions');

Route::redirect('/product', '/#technology', 301);
