<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogCommentController;
use App\Http\Controllers\Admin\BlogPageController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CustomPageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PageVisitController;
use App\Http\Controllers\Admin\ProgramCategoryController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SiteinfoController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProgramController as FrontendProgramController;
use App\Http\Controllers\Frontend\UniversityController as FrontendUniversityController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/blog', [FrontendBlogController::class, 'index'])->name('frontend.blog.index');
Route::get('/blog/{post:slug}', [FrontendBlogController::class, 'show'])->name('frontend.blog.show');
Route::get('/programs', [FrontendProgramController::class, 'index'])->name('frontend.programs.index');
Route::get('/programs/{program:slug}', [FrontendProgramController::class, 'show'])->name('frontend.programs.show');
Route::get('/universities', [FrontendUniversityController::class, 'index'])->name('frontend.universities.index');
Route::get('/universities/{university:slug}', [FrontendUniversityController::class, 'show'])->name('frontend.universities.show');
Route::get('/frontend/programs.html', [FrontendProgramController::class, 'index']);
Route::get('/frontend/program-single.html', [FrontendProgramController::class, 'legacyShow']);
Route::get('/frontend/blog.html', [FrontendBlogController::class, 'index']);
Route::get('/frontend/blog-single.html', [FrontendBlogController::class, 'legacyShow']);
Route::redirect('/frontend/universities.html', '/universities');
Route::get('/frontend/university-single.html', [FrontendUniversityController::class, 'legacyShow']);

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'storeAdmin'])->name('admin.login.store');
});

Route::redirect('/admin/admin/login', '/admin/login');
Route::redirect('/admin/admin/dashboard', '/admin/dashboard');
Route::redirect('/admin/index.html', '/admin/dashboard');
Route::redirect('/admin/index2.html', '/admin/dashboard');
Route::redirect('/admin/index3.html', '/admin/dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('abouts', AboutController::class);
    Route::resource('siteinfo', SiteinfoController::class);
    Route::resource('blog-categories', BlogCategoryController::class);
    Route::resource('blog-pages', BlogPageController::class);
    Route::resource('blog-posts', BlogPostController::class);
    Route::resource('blog-comments', BlogCommentController::class);
    Route::resource('universities', UniversityController::class);
    Route::resource('program-categories', ProgramCategoryController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('custom-pages', CustomPageController::class);
    Route::resource('news', NewsController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('admin-users', AdminUserController::class);
    Route::resource('page-visits', PageVisitController::class)->only(['index', 'show']);
    Route::resource('sliders', SliderController::class);
});

Route::get('/dashboard', function () {
    if (auth()->user()?->is_admin) {
        return redirect('/admin/dashboard');
    }

    return redirect()->route('frontend.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
