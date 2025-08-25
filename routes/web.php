<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDFExportController;
use App\Livewire\Admin\AddCustomers;
use App\Livewire\Admin\Auth\LoginComponent;
use App\Livewire\Admin\Chat\ChatList;
use App\Livewire\Admin\Customers;
use App\Livewire\Admin\Dashboard\AdminDashboard;
use App\Livewire\Admin\Dashboard\DeliveryDashboard;
use App\Livewire\Admin\Dashboard\SalesDashboard;
use App\Livewire\Admin\DeliveryOrder\OrderListPending as DeliveryOrderOrderListPending;
use App\Livewire\Admin\DeliveryOrder\Profile as DeliveryOrderProfile;
use App\Livewire\Admin\DeliveryOrder\TrackCustomer;
use App\Livewire\Admin\Employee\AddEmployee;
use App\Livewire\Admin\Employee\EditEmployee;
use App\Livewire\Admin\Employee\Employee;
use App\Livewire\Admin\Gallery\GalleryList;
use App\Livewire\Admin\HRM\Roles;
use App\Livewire\Admin\HRM\RolesAndPermissions;
use App\Livewire\Admin\Orders\OrderListsComplete;
use App\Livewire\Admin\Orders\OrderListsPending;
use App\Livewire\Admin\Orders\OrderListsProgress;
use App\Livewire\Admin\Products\ProductCategory;
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Products\StockPurchase;
use App\Livewire\Admin\Reports\CustomerOrdersReports;
use App\Livewire\Admin\Reports\DailyReports;
use App\Livewire\Admin\Reports\ProfitNLossReports;
use App\Livewire\Admin\Reports\PurchaseReports;
use App\Livewire\Admin\Sales\Profile as SalesProfile;
use App\Livewire\Admin\SalesOrder\ListOfOrders;
use App\Livewire\Admin\SalesOrder\OrderListComplete;
use App\Livewire\Admin\SalesOrder\SalesReports;
use App\Livewire\Admin\Setting\HomeContent;
use App\Livewire\Admin\Setting\SettingList;
use App\Livewire\Admin\Shops\ShopList;
use App\Livewire\Admin\Shops\ShopListCreate;
use App\Livewire\Admin\Shops\ShopListUpdate;
use App\Livewire\DummyChat;
use App\Livewire\Website\AboutUs;
use App\Livewire\Website\Auth\LoginPage;
use App\Livewire\Website\Auth\RegisterPage;
use App\Livewire\Website\Auth\UserForgertPassword;
use App\Livewire\Website\Cart;
use App\Livewire\Website\Chat\UserChatList as ChatUserChatList;
use App\Livewire\Website\Checkout;
use App\Livewire\Website\ContactU;
use App\Livewire\Website\Dashboard\MyDashboard;
use App\Livewire\Website\Dashboard\MyOrders;
use App\Livewire\Website\Dashboard\MyWallet;
use App\Livewire\Website\Dashboard\Profile;
use App\Livewire\Website\IndexHome;
use App\Livewire\Website\Notification\AdminNotifications;
use App\Livewire\Website\POS\InvoicePOS;
use App\Livewire\Website\POS\POSApp;
use App\Livewire\Website\ReferalUsers;
use App\Livewire\Website\Services;
use App\Livewire\Website\Shop;
use App\Livewire\Website\Shops\CategoryProductsList;
use App\Livewire\Website\Shops\ProductsList as ShopsProducts;
use App\Livewire\Website\SingleProduct;
use App\Livewire\Website\SingleProductCheckout;
use App\Livewire\Website\TrackMyOrder\OrderFind;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/fcm_generate', [HomeController::class, 'fcmGenerate'])->name('fcmGenerate');
Route::post('/store-fcm-token', [HomeController::class, 'FCMstore'])->name('store.fcm.token');
Route::get('/send-notification/{token}', [HomeController::class, 'sendNotification'])->name('send.notification');


Route::get('/', IndexHome::class)->name('index');
Route::get('/about_us', AboutUs::class)->name('about');
Route::get('/services', Services::class)->name('services');
Route::get('/contact_us', ContactU::class)->name('contact');
Route::get('/shop', Shop::class)->name('shop');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/product/{id}', SingleProduct::class)->name('single.Product');
Route::get('/single-shop/{id}', ShopsProducts::class)->name('single.shops.Product');
Route::get('/product-category/{id}', CategoryProductsList::class)->name('category.product');
Route::get('/product-checkout/{id}/{quantity}', SingleProductCheckout::class)->name('single.Product.checkout');


Route::post('/checkout-us', [HomeController::class, 'store'])->name('checkout.store');

Route::post('/shop-save', [HomeController::class, 'ShopSave'])->name('shop.store');

Route::get('forget-password', UserForgertPassword::class)->name('user.forget.password');
Route::middleware('redirect.if.user')->group(function () {
    Route::get('/user-login', LoginPage::class)->name('user.login');
    Route::get('/user-register', RegisterPage::class)->name('user.register');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/user-dashboard', MyDashboard::class)->name('user.dashboard');
    Route::get('/user-orders', MyOrders::class)->name('user.orders');
    Route::get('/user-wallet', MyWallet::class)->name('user.wallet');
    Route::get('/user-trackorder', OrderFind::class)->name('user.track.order');
    Route::get('/user-profile', Profile::class)->name('user.profile');
    Route::get('/user-referal', ReferalUsers::class)->name('user.referal');
    Route::get('/user-notification', AdminNotifications::class)->name('user.notification');
});


Route::get('/user_chat_list', ChatUserChatList::class)->name('user.chat')->middleware('permission:users.chats');
Route::get('/pos', POSApp::class)->name('users.pos')->middleware('permission:users.pos');
Route::get('/pos-invoice', InvoicePOS::class)->name('user.pos.invoice')->middleware('permission:users.pos.invoice');

Route::get('/orders-pending', OrderListsPending::class)->name('users.orders.list.pending')->middleware('permission:users.orders.list.pending');
Route::get('/orders-progress', OrderListsProgress::class)->name('users.orders.list.progress')->middleware('permission:users.orders.list.progress');
Route::get('/orders-complete', OrderListsComplete::class)->name('users.orders.list.complete')->middleware('permission:users.orders.list.complete');






// Admin



// Auth::routes();
Route::get('/login', LoginComponent::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout')->middleware('auth');

Route::post('/user_logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('user.login');
})->name('user.logout')->middleware('auth');




Route::middleware(['auth'])->group(function () {
    // Admin Team
    Route::get('/admin-dashbaord', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/stock-purchase', StockPurchase::class)->name('admin.stock.purchase');

    Route::get('/gallery', GalleryList::class)->name('admin.gallery');
    // Setting
    Route::get('/setting', SettingList::class)->name('admin.setting');
    // Route::get('/home-setting', HomeContent::class)->name('admin.setting.home');

    Route::get('/customers', Customers::class)->name('admin.customers');

    Route::get('/admin-notification', [HomeController::class, 'GetNotifications'])->name('admin.notification');
    Route::post('/notifications', [HomeController::class, 'StoreNotifications'])->name('notifications.store');

    Route::get('/reports/sales-reports', SalesReports::class)->name('admin.sales.reports');
    Route::get('/reports/purchase-reports', PurchaseReports::class)->name('admin.sales.purchase.reports');
    Route::get('/reports/profit-lose-reports', ProfitNLossReports::class)->name('admin.sales.profit.reports');
    Route::get('/reports/orders-reports', CustomerOrdersReports::class)->name('admin.sales.customer.reports');
    Route::get('/reports/daily-reports', DailyReports::class)->name('admin.sales.daily.reports');

    Route::get('/admin/sales-report/export/{shop?}/{from?}/{to?}', [PDFExportController::class, 'salesReport'])->name('sales.export');
    Route::get('/admin/purchase-report/export/{shop?}/{from?}/{to?}', [PDFExportController::class, 'PurchaseReport'])->name('sales.purchase.export');
    Route::get('/admin/daily-report/export', [PDFExportController::class, 'DailyReport'])->name('sales.daily.export');
    Route::get('/admin/orders-customer/export', [PDFExportController::class, 'OrderReport'])->name('sales.orderreport.export');


    // Route::get('/create_customers', AddCustomers::class)->name('admin.create.customers')->middleware('permission:create.customers');

    Route::get('/create_employee', AddEmployee::class)->name('admin.create.employee')->middleware('permission:create.customers');

    Route::get('/create_employee/{id}', EditEmployee::class)->name('admin.edit.employee')->middleware(('permission:edit.employee'));
    Route::get('/manage_employee', Employee::class)->name('admin.employee')->middleware('permission:manage.employees');

    Route::get('/manage_product_category', ProductCategory::class)->name('admin.product.category')->middleware('permission:manage.product.category');
    Route::get('/manage_product', ProductList::class)->name('admin.list.product')->middleware('permission:manage.product.list');
    Route::get('/manage_role', RolesAndPermissions::class)->name('admin.manage.role');
    // ->middleware('permission:manage.roles');
    Route::get('/add_roles', Roles::class)->name('admin.add.role');
    // ->middleware('permission:manage.roles');
    Route::get('/chat_list', ChatList::class)->name('admin.manage.chat')->middleware('permission:manage.chats');
    Route::get('/shops', ShopList::class)->name('admin.manage.shops')->middleware('permission:manage.shops');
    Route::get('/shops_create', ShopListCreate::class)->name('admin.manage.shops.create')->middleware('permission:manage.shops');
    Route::get('/shops_update/{id}', ShopListUpdate::class)->name('admin.manage.shops.update')->middleware('permission:manage.shops');


    // Delivery team
    Route::get('/delivery-dashbaord', DeliveryDashboard::class)->name('delivery.dashboard');
    Route::get('/delivery/orderlist', DeliveryOrderOrderListPending::class)->name('delivery.order.orderlist');
    Route::get('/delivery/profile', DeliveryOrderProfile::class)->name('delivery.profile');
    Route::get('/delivery/TrackOrder', TrackCustomer::class)->name('delivery.track');


    // Sales Team
    Route::get('/sales-dashbaord', SalesDashboard::class)->name('sales.dashboard');
    Route::get('/sales/order-list', ListOfOrders::class)->name('sales.orderList');
    Route::get('/sales-reports', OrderListComplete::class)->name('sales.reports');
    Route::get('/sales-profile', SalesProfile::class)->name('sales.profile');
});





// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/dummy', DummyChat::class)->name('dummy');
// Route::get('/dummy', [HomeController::class, 'indexEmail'])->name('indexEmail');
