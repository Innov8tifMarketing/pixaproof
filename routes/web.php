<?php

use App\Http\Controllers\CspReportController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/*
 * CSP violation collector. Browsers post here with no CSRF token and no
 * cookies, so session and CSRF middleware are stripped: CSRF would reject every
 * report, and StartSession would mint a throwaway cookie per report.
 * ShareErrorsFromSession must go with StartSession or it throws.
 *
 * NOTE: this site is behind Cloudflare and trustProxies is not configured, so
 * the throttle key is the Cloudflare edge IP, not the visitor. That makes this
 * closer to a global cap than a per-client one — sized generously to suit.
 */
Route::post('/csp-report', CspReportController::class)
    ->withoutMiddleware([
        // Laravel 12 name. (Laravel 13 renamed this to PreventRequestForgery —
        // the innov8tif app on the same server uses that name.) Getting this
        // wrong fails loudly but confusingly: CSRF stays active, reaches for the
        // session that StartSession below has just removed, and every report
        // 500s with "Session store not set on request".
        ValidateCsrfToken::class,
        StartSession::class,
        ShareErrorsFromSession::class,
    ])
    ->middleware('throttle:300,1')
    ->name('csp.report');

// Main pages
Route::view('/', 'pages.home')->name('home');
Route::view('/privacy', 'pages.privacy')->name('privacy');

// Contact page (demo request form - kept as separate page)
Route::view('/contact', 'pages.contact')->name('contact');

// Anchor redirects for single-page sections
Route::redirect('/technology', '/#technology', 301);
Route::redirect('/about', '/#about', 301);
Route::redirect('/company/about', '/#about', 301);
Route::redirect('/company/contact', '/contact', 301);

// Legacy 301 redirects for old solution pages (all redirect to homepage use cases section)
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

// Legacy 301 redirects for old resource pages
Route::redirect('/resources/injection-attacks', '/', 301);
Route::redirect('/resources/fraud-statistics', '/', 301);
Route::redirect('/resources/compliance', '/', 301);
Route::redirect('/resources/case-studies', '/', 301);

// 301 Redirects (SEO preservation for removed B2C pages)
Route::permanentRedirect('/pricing', '/contact');
Route::permanentRedirect('/how-it-works', '/#technology');
Route::permanentRedirect('/enterprise', '/#solutions');

// Legacy route alias for technology page
Route::redirect('/product', '/#technology', 301);
