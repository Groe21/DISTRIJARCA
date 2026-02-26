<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\HomeHeroController;
use App\Http\Controllers\Admin\HomeAboutController;
use App\Http\Controllers\Admin\HomeContactController;
// use App\Http\Controllers\Admin\MensajeController;
use App\Http\Controllers\Admin\SettingsController;

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

// Página principal
Route::get('/', function () {
    $sections = \App\Models\HomeSection::with('category')
        ->activas()
        ->ordenadas()
        ->get();

    $hero = \App\Models\HomeHero::first();
    $about = \App\Models\HomeAbout::first();
    $contact = \App\Models\HomeContact::first();
    
    return view('home', compact('sections', 'hero', 'about', 'contact'));
})->name('home');

// Formulario de contacto
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas del panel de administración (protegidas)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Gestión de usuarios
    Route::resource('users', UserController::class)->names('admin.users');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::post('/users/{user}/change-password', [UserController::class, 'changePassword'])->name('admin.users.change-password');
    Route::get('/activity-logs', [UserController::class, 'activityLogs'])->name('admin.users.activity-logs');

    // Gestión de categorías
    Route::resource('categories', CategoryController::class)->names('admin.categories')->except(['show']);
    Route::patch('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');

    // Gestión de productos
    Route::resource('products', ProductController::class)->names('admin.products');
    Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('admin.products.toggle-status');
    Route::patch('/products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('admin.products.toggle-featured');

    // Gestión de secciones de la página principal
    Route::resource('home-sections', HomeSectionController::class)->names('admin.home-sections');
    Route::patch('/home-sections/{homeSection}/toggle-status', [HomeSectionController::class, 'toggleStatus'])->name('admin.home-sections.toggle-status');
    Route::post('/home-sections/update-orden', [HomeSectionController::class, 'updateOrden'])->name('admin.home-sections.update-orden');

    // Hero principal (solo actualización desde Secciones Home)
    Route::put('/home-hero', [HomeHeroController::class, 'update'])->name('admin.home-hero.update');

    // Sección Nosotros (solo actualización desde Secciones Home)
    Route::put('/home-about', [HomeAboutController::class, 'update'])->name('admin.home-about.update');

    // Sección Contacto (solo actualización desde Secciones Home)
    Route::put('/home-contact', [HomeContactController::class, 'update'])->name('admin.home-contact.update');

    // Gestión de mensajes (DESHABILITADA)
    // Route::resource('mensajes', MensajeController::class)->names('admin.mensajes')->only(['index', 'show', 'update', 'destroy']);
    // Route::patch('/mensajes/{mensaje}/marcar-leido', [MensajeController::class, 'marcarLeido'])->name('admin.mensajes.marcar-leido');
    // Route::patch('/mensajes/{mensaje}/toggle-respondido', [MensajeController::class, 'toggleRespondido'])->name('admin.mensajes.toggle-respondido');

    // Configuración
    Route::get('/settings/email', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::put('/settings/email', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/settings/test-email', [SettingsController::class, 'testEmail'])->name('admin.settings.test-email');
});
