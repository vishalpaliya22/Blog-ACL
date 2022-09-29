<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController as AdminTagCtrl;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Common\StaffController;
use App\Http\Controllers\Common\BlogController as AdminBlogCtrl;
use App\Http\Middleware\CheckUserStatus;

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

/*Route::get('/', function() {
	return view('home', [ 'page_title' => 'Home' ]);
})->name('home');*/

Route::get('/',  [ AuthController::class, 'adminLoginForm' ])->name('admin.login-form');
Route::as('auth.')->middleware([ 'guest', 'prevent-back-history' ])->group(function() {
	Route::get('/admin', [ AuthController::class, 'adminLoginForm' ])->name('admin.login-form');
	Route::post('/admin', [ AuthController::class,'adminLogin' ])->name('admin.login');
	Route::get('/blog-operator', [ AuthController::class,'blogOpStaffLoginForm' ])->name('blog-operator.login-form');
	Route::post('/blog-operator', [ AuthController::class,'blogOpStaffLogin' ])->name('blog-operator.login');
});

Route::prefix('blog-operator')->as('blog-operator.')->middleware([ 'auth:tour_operator_staff', 'prevent-back-history', 'check-user-status', ])->group(function() {
	Route::post('logout', [ AuthController::class, 'logout' ])->name('logout')->withoutMiddleware([ CheckUserStatus::class ]);
	Route::get('dashboard', [ BlogController::class, 'dashboard' ])->name('dashboard');
	Route::resource('tag', AdminTagCtrl::class)->except([ 'show', 'update' ]);
	Route::prefix('tag')->as('tag.')->group(function() {
		Route::post('update-general/{id}', [ AdminTagCtrl::class, 'updateGeneral' ])->name('update-general');
	});
	Route::prefix('comment')->as('comment.')->group(function() {
		Route::post('comment-add', [ AdminBlogCtrl::class, 'commentAdd' ])->name('commentAdd');
	});
	Route::prefix('blog')->as('blog.')->group(function() {
		Route::post('index-ahr/{tourOpId?}', [ AdminBlogCtrl::class, 'indexAHR' ])->name('index-ahr');
		Route::post('update-general/{id}', [ AdminBlogCtrl::class, 'updateGeneral' ])->name('update-general')->whereNumber('id');
	});
	Route::resource('blog', AdminBlogCtrl::class)->except(['update' ]);
	Route::prefix('staff')->as('staff.')->group(function() {
		Route::post('index-ahr', [ StaffController::class, 'indexAHR' ])->name('index-ahr');
		Route::post('update-general/{id}', [ StaffController::class, 'updateGeneral' ])->name('update-general');
		Route::post('update-role/{id}', [ StaffController::class, 'updateRole' ])->name('update-role');
	});
	Route::resource('staff', StaffController::class)->except([ 'show', 'update' ]);
});

// Admin Routes Start
Route::prefix('admin')->as('admin.')->middleware([ 'auth:admin', 'prevent-back-history', 'check-user-status', 'check-admin' ])->group(function() {
	Route::post('logout', [ AuthController::class, 'logout' ])->name('logout')->withoutMiddleware([ CheckUserStatus::class ]);
	Route::get('dashboard', [ AdminController::class, 'dashboard' ])->name('dashboard');
	Route::resource('admin-user', AdminUserController::class)->except([ 'show' ]);	
	Route::post('admin-change-password/{id}', [AdminUserController::class, 'changeProfilePassword'])->name('change-password');	
	Route::resource('role', RoleController::class)->except(['show']);
	Route::prefix('blog-operator')->as('blog-operator.')->group(function() {
		Route::resource('tag', AdminTagCtrl::class)->except([ 'show', 'update' ]);
		Route::prefix('tag')->as('tag.')->group(function() {
			Route::post('update-general/{id}', [ AdminTagCtrl::class, 'updateGeneral' ])->name('update-general');
		});
		Route::prefix('blog')->as('blog.')->group(function() {
			Route::post('index-ahr/{tourOpId?}', [ AdminBlogCtrl::class, 'indexAHR' ])->name('index-ahr');
			Route::post('update-general/{id}', [ AdminBlogCtrl::class, 'updateGeneral' ])->name('update-general')->whereNumber('id');
		});
		Route::resource('blog', AdminBlogCtrl::class)->except(['update' ]);
		Route::prefix('comment')->as('comment.')->group(function() {
			Route::post('comment-add', [ AdminBlogCtrl::class, 'commentAdd' ])->name('commentAdd');
		});
		Route::prefix('staff')->as('staff.')->group(function() {
			Route::post('index-ahr', [ StaffController::class, 'indexAHR' ])->name('index-ahr');
			Route::post('update-general/{id}', [ StaffController::class, 'updateGeneral' ])->name('update-general');
			Route::post('update-role/{id}', [ StaffController::class, 'updateRole' ])->name('update-role');
		});
		Route::resource('staff', StaffController::class)->except([ 'show', 'update' ]);
	});
});





