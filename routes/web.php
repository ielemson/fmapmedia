<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;

/*
|--------------------------------------------------------------------------
| Frontend Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MagazineController;
use App\Http\Controllers\Frontend\NewsPageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\Frontend\TeamController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\VendorImpersonationController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GalleryAlbumController;
/*
|--------------------------------------------------------------------------
| Customer Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Customer\CustomerMagazineController;
use App\Http\Controllers\Customer\CustomerOrderController;

/*
|--------------------------------------------------------------------------
| Vendor Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Vendor\SupportTicketController as VendorSupportTicketController;
use App\Http\Controllers\Vendor\VendorBankAccountController;
use App\Http\Controllers\Vendor\VendorCommissionController;
use App\Http\Controllers\Vendor\VendorNotificationController;
use App\Http\Controllers\Vendor\VendorRegisterController;
use App\Http\Controllers\Vendor\VendorSalesController;
use App\Http\Controllers\Vendor\VendorWithdrawalController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/project', 'project')->name('frontend.project');
    Route::get('/gallery/{galleryAlbum:slug}', 'gallery')->name('gallery.show');
    Route::get('/become-a-vendor', 'becomeVendor')->name('become.vendor');
});

/*
|--------------------------------------------------------------------------
| Contact Routes
|--------------------------------------------------------------------------
*/

// Legacy aliases retained for backward compatibility.
Route::get('/contact-us/captcha', [ContactController::class, 'captcha']);
Route::post('/contact-us', [ContactController::class, 'store'])
    ->middleware('throttle:5,1');

Route::get('/contact/captcha', [ContactController::class, 'captcha'])
    ->name('contact.captcha');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| News, Team and Service Routes
|--------------------------------------------------------------------------
*/

Route::controller(NewsPageController::class)
    ->prefix('news')
    ->name('news.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{slug}', 'show')->name('show');
    });

Route::get('/team/{teamMember:slug}', [TeamController::class, 'show'])
    ->name('team.member.show');

Route::controller(FrontendServiceController::class)
    ->prefix('services')
    ->name('services.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{service:slug}', 'show')->name('show');
    });

/*
|--------------------------------------------------------------------------
| Public Magazine Routes
|--------------------------------------------------------------------------
*/

Route::get('/magazines', [MagazineController::class, 'index'])
    ->name('magazines.index');

Route::get('/magazine/{slug}', [MagazineController::class, 'show'])
    ->name('magazine.show');

Route::get(
    '/ref/{referralSlug}/product/{productSlug}',
    [MagazineController::class, 'product']
)->name('referral.product');

/*
|--------------------------------------------------------------------------
| Vendor Registration
|--------------------------------------------------------------------------
*/

Route::controller(VendorRegisterController::class)
    ->prefix('vendor/register')
    ->name('vendor.register')
    ->group(function () {
        Route::get('/', 'create');
        Route::post('/', 'store')->name('.store');
    });

// /*
// |--------------------------------------------------------------------------
// | Referral Routes
// |--------------------------------------------------------------------------
// */

// Route::get(
//     '/ref/{referralSlug}/product/{productSlug}',
//     [ReferralController::class, 'product']
// )->name('referral.product');

/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/

Route::controller(CheckoutController::class)
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {
        // Keep the static callback route before the dynamic {slug} route.
        Route::get('paystack/callback', 'paystackCallback')
            ->name('paystack.callback');

        Route::get('{slug}', 'show')->name('show');
        Route::post('{slug}', 'store')->name('store');
    });

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Shared Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Customer Dashboard Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard/customer')
        ->name('customer.')
        ->group(function () {
            Route::get('library', [CustomerMagazineController::class, 'library'])
                ->name('library');

            Route::controller(CustomerOrderController::class)
                ->prefix('orders')
                ->name('orders.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{order}', 'show')->name('show');
                });

            Route::controller(CustomerMagazineController::class)
                ->prefix('magazines')
                ->name('magazines.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{slug}', 'show')->name('show');
                });
        });

    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard/admin')
        ->name('admin.')
        ->group(function () {
            // News management
            Route::resource('news-categories', NewsCategoryController::class);
            Route::resource('news', NewsController::class);

            // Gallery management
            Route::resource('gallery-albums', GalleryAlbumController::class);

            // Product management
            Route::resource('product-categories', ProductCategoryController::class)
                ->except(['show']);
            Route::resource('products', ProductController::class);

            // User management
            Route::patch('users/{user}/suspend', [UserController::class, 'suspend'])
                ->name('users.suspend');
            Route::patch('users/{user}/activate', [UserController::class, 'activate'])
                ->name('users.activate');
            Route::resource('users', UserController::class);

            // Order management
            Route::controller(AdminOrderController::class)
                ->prefix('orders')
                ->name('orders.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{order}', 'show')->name('show');
                });

            // Notifications
            Route::controller(AdminNotificationController::class)
                ->prefix('notifications')
                ->name('notifications.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('read-all', 'markAllRead')->name('readAll');
                    Route::get('{notification}', 'show')->name('show');
                });

            // Withdrawals
            Route::controller(AdminWithdrawalController::class)
                ->prefix('withdrawals')
                ->name('withdrawals.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{withdrawal}', 'show')->name('show');
                    Route::patch('{withdrawal}/approve', 'approve')->name('approve');
                    Route::patch('{withdrawal}/reject', 'reject')->name('reject');
                    Route::patch('{withdrawal}/mark-paid', 'markAsPaid')->name('mark-paid');
                });

            // Support tickets
            Route::controller(AdminSupportTicketController::class)
                ->prefix('support')
                ->name('support.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{supportTicket}', 'show')->name('show');
                    Route::post('{supportTicket}/reply', 'reply')->name('reply');
                    Route::patch('{supportTicket}/status', 'updateStatus')->name('status');
                    Route::patch('{supportTicket}/priority', 'updatePriority')->name('priority');
                    Route::patch('{supportTicket}/assign', 'assign')->name('assign');
                });

            // General settings
            Route::controller(AdminSettingController::class)
                ->prefix('settings')
                ->name('settings.')
                ->group(function () {
                    Route::get('/general', 'edit')->name('general');
                    Route::put('/general/update', 'update')->name('general.update');
                });

            // Vendor management
            Route::controller(AdminVendorController::class)
                ->prefix('vendors')
                ->name('vendors.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{vendor}', 'show')->name('show');
                    Route::patch('{vendor}/approve', 'approve')->name('approve');
                    Route::patch('{vendor}/reject', 'reject')->name('reject');
                    Route::patch('{vendor}/suspend', 'suspend')->name('suspend');
                    Route::patch('{vendor}/mark-pending', 'markPending')->name('mark-pending');
                    Route::post('{vendor}/login-as', [VendorImpersonationController::class, 'loginAs'])
                        ->name('login-as');
                });

            // Team members
            Route::controller(TeamMemberController::class)
                ->prefix('team-members')
                ->name('team-members.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/{teamMember}', 'show')->name('show');
                    Route::get('/{teamMember}/edit', 'edit')->name('edit');
                    Route::put('/{teamMember}/update', 'update')->name('update');
                    Route::delete('/{teamMember}/delete', 'destroy')->name('destroy');
                });

            // Services
            Route::controller(ServiceController::class)
                ->prefix('services')
                ->name('services.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/{service}', 'show')->name('show');
                    Route::get('/{service}/edit', 'edit')->name('edit');
                    Route::put('/{service}/update', 'update')->name('update');
                    Route::delete('/{service}/delete', 'destroy')->name('destroy');
                });
        });

    /*
    |--------------------------------------------------------------------------
    | Leave Vendor Impersonation
    |--------------------------------------------------------------------------
    */

    Route::controller(VendorImpersonationController::class)
        ->prefix('impersonation')
        ->name('impersonation.')
        ->group(function () {
            Route::post('leave', 'leave')->name('leave');
        });

    /*
    |--------------------------------------------------------------------------
    | Vendor Dashboard Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard/vendor')
        ->name('vendor.')
        ->group(function () {
            // Bank accounts
            Route::resource('bank-accounts', VendorBankAccountController::class)
                ->except(['show']);

            // Sales
            Route::get('sales', [VendorSalesController::class, 'index'])
                ->name('sales.index');

            // Commissions
            Route::get('commissions', [VendorCommissionController::class, 'index'])
                ->name('commissions.index');

            // Withdrawals
            Route::controller(VendorWithdrawalController::class)
                ->prefix('withdrawals')
                ->name('withdrawals.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                });

            // Notifications
            Route::controller(VendorNotificationController::class)
                ->prefix('notifications')
                ->name('notifications.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('read-all', 'markAllRead')->name('readAll');
                    Route::get('{notification}', 'show')->name('show');
                });

            // Support tickets
            Route::controller(VendorSupportTicketController::class)
                ->prefix('support')
                ->name('support.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('create', 'create')->name('create');
                    Route::post('/', 'store')->name('store');
                    Route::get('{supportTicket}', 'show')->name('show');
                    Route::post('{supportTicket}/reply', 'reply')->name('reply');
                    Route::patch('{supportTicket}/close', 'close')->name('close');
                    Route::patch('{supportTicket}/reopen', 'reopen')->name('reopen');
                });
        });

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */

    Route::controller(ProfileController::class)
        ->prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';