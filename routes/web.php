<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;

/*
|--------------------------------------------------------------------------
| Frontend Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\MagazineController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\NewsPageController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\AdminWithdrawalController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;

/*
|--------------------------------------------------------------------------
| Customer Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerMagazineController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\TeamController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
/*
|--------------------------------------------------------------------------
| Vendor Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Vendor\VendorRegisterController;
use App\Http\Controllers\Vendor\VendorSalesController;
use App\Http\Controllers\Vendor\VendorCommissionController;
use App\Http\Controllers\Vendor\VendorWithdrawalController;
use App\Http\Controllers\Vendor\VendorBankAccountController;
use App\Http\Controllers\Vendor\VendorNotificationController;
use App\Http\Controllers\Vendor\SupportTicketController as VendorSupportTicketController;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])
    ->name('index');

Route::get('/about', [PageController::class, 'about'])
    ->name('about');

Route::get('/contact-us/captcha', [ContactController::class, 'captcha'])
    ->name('contact.captcha');

Route::get('/contact', [PageController::class, 'contact'])
    ->name('contact');


Route::get('/project', [PageController::class, 'project'])
    ->name('frontend.project');

    Route::post('/contact-us', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/become-a-vendor', [PageController::class, 'becomeVendor'])
    ->name('become.vendor');
// Route::get('/news', [NewsPageController::class, 'index'])
//     ->name('news.index');

Route::get('/news', [NewsPageController::class, 'index'])
    ->name('news.index');

Route::get('/news/{slug}', [NewsPageController::class, 'show'])
    ->name('news.show');

Route::get('/team/{teamMember:slug}', [TeamController::class, 'show'])
    ->name('team.member.show');
    
    Route::get('/services', [FrontendServiceController::class, 'index'])
    ->name('services.index');

Route::get('/services/{service:slug}', [FrontendServiceController::class, 'show'])
    ->name('services.show');


Route::get('/contact/captcha', [ContactController::class, 'captcha'])
    ->name('contact.captcha');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
    

/*
|--------------------------------------------------------------------------
| Public Magazine Routes
|--------------------------------------------------------------------------
*/

Route::get('/magazines', [MagazineController::class, 'index'])
    ->name('magazines.index');

Route::get('/magazine/{slug}', [MagazineController::class, 'show'])
    ->name('magazine.show');


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


/*
|--------------------------------------------------------------------------
| Referral Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/ref/{referralSlug}/product/{productSlug}',
    [ReferralController::class, 'product']
)->name('referral.product');


/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/

Route::controller(CheckoutController::class)
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {
        Route::get('{slug}', 'show')->name('show');
        Route::post('{slug}', 'store')->name('store');

        Route::get('paystack/callback', 'paystackCallback')
            ->name('paystack.callback');
    });


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

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
    |
    | URL structure:
    | /dashboard/customer/...
    |
    | Route names:
    | customer.library
    | customer.orders.index
    | customer.orders.show
    | customer.magazines.index
    | customer.magazines.show
    |
    */

    Route::prefix('dashboard/customer')
        ->name('customer.')
        ->group(function () {

            /*
            | Customer Library
            */
            Route::get(
                'library',
                [CustomerMagazineController::class, 'library']
            )->name('library');


            /*
            | Customer Orders
            */
            Route::controller(CustomerOrderController::class)
                ->prefix('orders')
                ->name('orders.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{order}', 'show')->name('show');
                });


            /*
            | Customer Magazines
            */
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
    |
    | URL structure:
    | /dashboard/admin/...
    |
    | Route names:
    | admin.news.index
    | admin.products.index
    | admin.users.index
    | admin.orders.index
    | admin.withdrawals.index
    |
    */

    Route::prefix('dashboard/admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | News Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'news-categories',
                NewsCategoryController::class
            );

            Route::resource(
                'news',
                NewsController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Product Management
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'product-categories',
                ProductCategoryController::class
            )->except(['show']);

            Route::resource(
                'products',
                ProductController::class
            );


            /*
            |--------------------------------------------------------------------------
            | User Management
            |--------------------------------------------------------------------------
            */

            Route::patch(
                'users/{user}/suspend',
                [UserController::class, 'suspend']
            )->name('users.suspend');

            Route::patch(
                'users/{user}/activate',
                [UserController::class, 'activate']
            )->name('users.activate');

            Route::resource(
                'users',
                UserController::class
            );


            /*
            |--------------------------------------------------------------------------
            | Order Management
            |--------------------------------------------------------------------------
            */

            Route::controller(AdminOrderController::class)
                ->prefix('orders')
                ->name('orders.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{order}', 'show')->name('show');
                });


            /*
            |--------------------------------------------------------------------------
            | Admin Notifications
            |--------------------------------------------------------------------------
            */

            Route::controller(AdminNotificationController::class)
                ->prefix('notifications')
                ->name('notifications.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');

                    Route::post('read-all', 'markAllRead')
                        ->name('readAll');

                    Route::get('{notification}', 'show')
                        ->name('show');
                });


            /*
            |--------------------------------------------------------------------------
            | Withdrawal Management
            |--------------------------------------------------------------------------
            */

            Route::controller(AdminWithdrawalController::class)
                ->prefix('withdrawals')
                ->name('withdrawals.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');

                    Route::get('{withdrawal}', 'show')
                        ->name('show');

                    Route::patch('{withdrawal}/approve', 'approve')
                        ->name('approve');

                    Route::patch('{withdrawal}/reject', 'reject')
                        ->name('reject');

                    Route::patch(
                        '{withdrawal}/mark-paid',
                        'markAsPaid'
                    )->name('mark-paid');
                });


            /*
            |--------------------------------------------------------------------------
            | Admin Support Tickets
            |--------------------------------------------------------------------------
            */

            Route::controller(AdminSupportTicketController::class)
                ->prefix('support')
                ->name('support.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');

                    Route::get('{supportTicket}', 'show')
                        ->name('show');

                    Route::post(
                        '{supportTicket}/reply',
                        'reply'
                    )->name('reply');

                    Route::patch(
                        '{supportTicket}/status',
                        'updateStatus'
                    )->name('status');

                    Route::patch(
                        '{supportTicket}/priority',
                        'updatePriority'
                    )->name('priority');

                    Route::patch(
                        '{supportTicket}/assign',
                        'assign'
                    )->name('assign');
                });
           
                
                Route::controller(AdminSettingController::class)
                ->prefix('settings')
                ->name('settings.')
                ->group(function () {
                    Route::get('/general', 'edit')->name('general');

                    Route::put('/general/update', 'update')
                        ->name('general.update');                   
                });


Route::controller(AdminVendorController::class)
    ->prefix('vendors')
    ->name('vendors.')
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('{vendor}', 'show')
            ->name('show');

        Route::patch('{vendor}/approve', 'approve')
            ->name('approve');

        Route::patch('{vendor}/reject', 'reject')
            ->name('reject');

        Route::patch('{vendor}/suspend', 'suspend')
            ->name('suspend');

        Route::patch('{vendor}/mark-pending', 'markPending')
            ->name('mark-pending');
    });

    Route::controller(TeamMemberController::class)
    ->prefix('team-members')
    ->name('team-members.')
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/create', 'create')
            ->name('create');

        Route::post('/store', 'store')
            ->name('store');

        Route::get('/{teamMember}', 'show')
            ->name('show');

        Route::get('/{teamMember}/edit', 'edit')
            ->name('edit');

        Route::put('/{teamMember}/update', 'update')
            ->name('update');

        Route::delete('/{teamMember}/delete', 'destroy')
            ->name('destroy');
    });


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
    | Vendor Dashboard Routes
    |--------------------------------------------------------------------------
    |
    | URL structure:
    | /dashboard/vendor/...
    |
    | Route names:
    | vendor.bank-accounts.index
    | vendor.sales.index
    | vendor.commissions.index
    | vendor.withdrawals.index
    | vendor.support.index
    |
    */

    Route::prefix('dashboard/vendor')
        ->name('vendor.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Vendor Bank Accounts
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'bank-accounts',
                VendorBankAccountController::class
            )->except(['show']);


            /*
            |--------------------------------------------------------------------------
            | Vendor Sales
            |--------------------------------------------------------------------------
            */

            Route::get(
                'sales',
                [VendorSalesController::class, 'index']
            )->name('sales.index');


            /*
            |--------------------------------------------------------------------------
            | Vendor Commissions
            |--------------------------------------------------------------------------
            */

            Route::get(
                'commissions',
                [VendorCommissionController::class, 'index']
            )->name('commissions.index');


            /*
            |--------------------------------------------------------------------------
            | Vendor Withdrawals
            |--------------------------------------------------------------------------
            */

            Route::controller(VendorWithdrawalController::class)
                ->prefix('withdrawals')
                ->name('withdrawals.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
                });


            /*
            |--------------------------------------------------------------------------
            | Vendor Notifications
            |--------------------------------------------------------------------------
            */

            Route::controller(VendorNotificationController::class)
                ->prefix('notifications')
                ->name('notifications.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');

                    Route::post('read-all', 'markAllRead')
                        ->name('readAll');

                    Route::get('{notification}', 'show')
                        ->name('show');
                });


            /*
            |--------------------------------------------------------------------------
            | Vendor Support Tickets
            |--------------------------------------------------------------------------
            */

            Route::controller(VendorSupportTicketController::class)
                ->prefix('support')
                ->name('support.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');

                    Route::get('create', 'create')
                        ->name('create');

                    Route::post('/', 'store')
                        ->name('store');

                    Route::get('{supportTicket}', 'show')
                        ->name('show');

                    Route::post(
                        '{supportTicket}/reply',
                        'reply'
                    )->name('reply');

                    Route::patch(
                        '{supportTicket}/close',
                        'close'
                    )->name('close');

                    Route::patch(
                        '{supportTicket}/reopen',
                        'reopen'
                    )->name('reopen');
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