<?php

use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorImpersonationController;
use App\Http\Controllers\Customer\CustomerMagazineController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MagazineController;
use App\Http\Controllers\Frontend\NewsPageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\Frontend\TeamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\SupportTicketController as VendorSupportTicketController;
use App\Http\Controllers\Vendor\VendorBankAccountController;
use App\Http\Controllers\Vendor\VendorCommissionController;
use App\Http\Controllers\Vendor\VendorNotificationController;
use App\Http\Controllers\Vendor\VendorRegisterController;
use App\Http\Controllers\Vendor\VendorSalesController;
use App\Http\Controllers\Vendor\VendorWithdrawalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages
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
| Contact Submissions
|--------------------------------------------------------------------------
|
| Turnstile is verified inside ContactController.
| The legacy POST URL uses the same validation and rate limit.
|
*/

Route::controller(ContactController::class)
    ->middleware('throttle:5,1')
    ->group(function () {
        Route::post('/contact', 'store')->name('contact.store');
        Route::post('/contact-us', 'store');
    });

/*
|--------------------------------------------------------------------------
| News
|--------------------------------------------------------------------------
*/

Route::controller(NewsPageController::class)
    ->prefix('news')
    ->name('news.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{slug}', 'show')->name('show');
    });

/*
|--------------------------------------------------------------------------
| Team and Services
|--------------------------------------------------------------------------
*/

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
| Public Magazines and Referrals
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

        Route::post('/', 'store')
            ->middleware('throttle:5,1')
            ->name('.store');
    });

/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::controller(CheckoutController::class)
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {
        // Static callback must precede the dynamic magazine route.
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
    | Customer Dashboard
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
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard/admin')
        ->name('admin.')
        ->group(function () {
            // News
            Route::resource('news-categories', NewsCategoryController::class);
            Route::resource('news', NewsController::class);

            // Gallery
            Route::resource('gallery-albums', GalleryAlbumController::class);

            // Products
            Route::resource('product-categories', ProductCategoryController::class)
                ->except(['show']);

            Route::resource('products', ProductController::class);

            // Users
            Route::patch('users/{user}/suspend', [UserController::class, 'suspend'])
                ->name('users.suspend');

            Route::patch('users/{user}/activate', [UserController::class, 'activate'])
                ->name('users.activate');

            Route::resource('users', UserController::class);

            // Orders
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

                    Route::patch('{withdrawal}/approve', 'approve')
                        ->name('approve');

                    Route::patch('{withdrawal}/reject', 'reject')
                        ->name('reject');

                    Route::patch('{withdrawal}/mark-paid', 'markAsPaid')
                        ->name('mark-paid');
                });

            // Support
            Route::controller(AdminSupportTicketController::class)
                ->prefix('support')
                ->name('support.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{supportTicket}', 'show')->name('show');
                    Route::post('{supportTicket}/reply', 'reply')->name('reply');

                    Route::patch('{supportTicket}/status', 'updateStatus')
                        ->name('status');

                    Route::patch('{supportTicket}/priority', 'updatePriority')
                        ->name('priority');

                    Route::patch('{supportTicket}/assign', 'assign')
                        ->name('assign');
                });

            // Settings
            Route::controller(AdminSettingController::class)
                ->prefix('settings')
                ->name('settings.')
                ->group(function () {
                    Route::get('general', 'edit')->name('general');
                    Route::put('general/update', 'update')->name('general.update');
                });

            // Vendors
            Route::controller(AdminVendorController::class)
                ->prefix('vendors')
                ->name('vendors.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{vendor}', 'show')->name('show');
                    Route::patch('{vendor}/approve', 'approve')->name('approve');
                    Route::patch('{vendor}/reject', 'reject')->name('reject');
                    Route::patch('{vendor}/suspend', 'suspend')->name('suspend');

                    Route::patch('{vendor}/mark-pending', 'markPending')
                        ->name('mark-pending');

                    Route::post(
                        '{vendor}/login-as',
                        [VendorImpersonationController::class, 'loginAs']
                    )->name('login-as');
                });

            // Team members
            Route::controller(TeamMemberController::class)
                ->prefix('team-members')
                ->name('team-members.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('create', 'create')->name('create');
                    Route::post('store', 'store')->name('store');
                    Route::get('{teamMember}', 'show')->name('show');
                    Route::get('{teamMember}/edit', 'edit')->name('edit');
                    Route::put('{teamMember}/update', 'update')->name('update');
                    Route::delete('{teamMember}/delete', 'destroy')->name('destroy');
                });

            // Services
            Route::controller(ServiceController::class)
                ->prefix('services')
                ->name('services.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('create', 'create')->name('create');
                    Route::post('store', 'store')->name('store');
                    Route::get('{service}', 'show')->name('show');
                    Route::get('{service}/edit', 'edit')->name('edit');
                    Route::put('{service}/update', 'update')->name('update');
                    Route::delete('{service}/delete', 'destroy')->name('destroy');
                });
        });

    /*
    |--------------------------------------------------------------------------
    | Leave Vendor Impersonation
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/impersonation/leave',
        [VendorImpersonationController::class, 'leave']
    )->name('impersonation.leave');

    /*
    |--------------------------------------------------------------------------
    | Vendor Dashboard
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard/vendor')
        ->name('vendor.')
        ->group(function () {
            Route::resource('bank-accounts', VendorBankAccountController::class)
                ->except(['show']);

            Route::get('sales', [VendorSalesController::class, 'index'])
                ->name('sales.index');

            Route::get('commissions', [VendorCommissionController::class, 'index'])
                ->name('commissions.index');

            Route::controller(VendorWithdrawalController::class)
                ->prefix('withdrawals')
                ->name('withdrawals.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                });

            Route::controller(VendorNotificationController::class)
                ->prefix('notifications')
                ->name('notifications.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('read-all', 'markAllRead')->name('readAll');
                    Route::get('{notification}', 'show')->name('show');
                });

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
    | Profile
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
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
