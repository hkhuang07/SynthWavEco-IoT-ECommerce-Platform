<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\SalerController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ManufacturesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\IoTDevicesController;
use App\Http\Controllers\DeviceMetricController;
use App\Http\Controllers\AlertThresholdsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ArticleTypeController;
use App\Http\Controllers\ArticleStatusController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

/*/ Google OAuth
Route::get('/login/google', [HomeController::class, 'getGoogleLogin'])->name('google.login');
Route::get('/login/google/callback', [HomeController::class, 'getGoogleCallback'])->name('google.callback');

// Custom Login/Register routes with proper POST methods
Route::get('/login', fn() => redirect()->route('user.login'))->name('login');
Route::get('/user/login', [HomeController::class, 'getLogin'])->name('user.login');
Route::post('/user/login', [LoginController::class, 'login'])->name('user.login.post');
Route::post('/user/logout', [LoginController::class, 'logout'])->name('user.logout');
Route::get('/user/register', [HomeController::class, 'getRegister'])->name('user.register');
Route::post('/user/register', [RegisterController::class, 'register'])->name('user.register.post');

// Password reset routes 
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
*/

Route::middleware('guest')->group(function () {
    // Google OAuth
    Route::get('/login/google', [HomeController::class, 'getGoogleLogin'])->name('google.login');
    Route::get('/login/google/callback', [HomeController::class, 'getGoogleCallback'])->name('google.callback');

    // Login/Register routes
    Route::get('/login', fn() => redirect()->route('user.login'))->name('login');
    Route::get('/user/login', [HomeController::class, 'getLogin'])->name('user.login');
    Route::post('/user/login', [LoginController::class, 'login'])->name('user.login.post');
    Route::get('/user/register', [HomeController::class, 'getRegister'])->name('user.register');
    Route::post('/user/register', [RegisterController::class, 'register'])->name('user.register.post');

    // Password reset routes 
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});
Route::post('/user/logout', [LoginController::class, 'logout'])->name('user.logout')->middleware('auth');

// Pages for logged-out guests
Route::name('frontend.')->group(function () {
    // Trang chủ
    Route::get('/', [HomeController::class, 'getHome'])->name('home');
    Route::get('/home', [HomeController::class, 'getHome'])->name('home');

    // Trang sản phẩm
    Route::get('/productscategories', [HomeController::class, 'getProductsCategories'])->name('products_categories');
    Route::get('/productsmanufactures', [HomeController::class, 'getProductManufacturer'])->name('products_manufactures');
    Route::get('/products_manu/{manufacturer_slug}', [HomeController::class, 'getProducts_Manufacturers'])->name('products.manufacturers');
    Route::get('/products_cate/{categoryname_slug}', [HomeController::class, 'getProducts_Categories'])->name('products.categories');
    Route::get('/products_manu/{manufacturer_slug}/{productname_slug}', [HomeController::class, 'getProduct_Manufacturer'])->name('products.product_manufacturer_details');
    Route::get('/products_cate/{categoryname_slug}/{productname_slug}', [HomeController::class, 'getProduct_Category'])->name('products.product_category_details');
    Route::get('/products', [HomeController::class, 'getProducts'])->name('products');

    // Trang tin tức
    Route::get('/articlestopics', [HomeController::class, 'getArticleTopics'])->name('articles_topics');
    Route::get('/articlestypes', [HomeController::class, 'getArticleTypes'])->name('articles_types');
    Route::get('/articles_top/{topicname_slug}', [HomeController::class, 'getArticles_Topics'])->name('articles.topics');
    Route::get('/articles_type/{article_type_slug}', [HomeController::class, 'getArticles_Types'])->name('articles.types');
    Route::get('/articles_type/{article_type_slug}/{title_slug}', [HomeController::class, 'getArticle_Type'])->name('articles.article_type_details');
    Route::get('/articles_top/{topicname_slug}/{title_slug}', [HomeController::class, 'getArticle_Topic'])->name('articles.article_topic_details');
    Route::get('/articles', [HomeController::class, 'getArticles'])->name('articles');
    Route::get('/articles/{topicname_slug}', [HomeController::class, 'getArticles'])->name('articles.topics');
    Route::get('/articles/{topicname_slug}/{title_slug}', [HomeController::class, 'getArticle_Details'])->name('article.details');
  
    // Trang giỏ hàng
    Route::get('/shoppingcard', [HomeController::class, 'getShoppingCard'])->name('shoppingcard');
    Route::get('/shoppingcard/add/{productname_slug}', [HomeController::class, 'getCard_Add'])->name('shoppingcard.add');
    Route::get('/shoppingcard/delete/{row_id}', [HomeController::class, 'getCard_Delete'])->name('shoppingcard.delete');
    Route::get('/shoppingcard/decrease/{row_id}', [HomeController::class, 'getCard_Decrease'])->name('shoppingcard.decrease');
    Route::get('/shoppingcard/increase/{row_id}', [HomeController::class, 'getCard_Increase'])->name('shoppingcard.increase');
    Route::post('/shoppingcard/update/{row_id}', [HomeController::class, 'updateCartQuantity'])->name('shoppingcard.update');
    Route::get('/shoppingcard/clear', [HomeController::class, 'clearCart'])->name('shoppingcard.clear');

    // Tìm kiếm
    Route::get('/search/products', [HomeController::class, 'searchProducts'])->name('search.products');
    Route::get('/search/articles', [HomeController::class, 'searchArticles'])->name('search.articles');

    // Trang tĩnh
    Route::get('/recruitment', [HomeController::class, 'getRecruitment'])->name('recruitment');
    Route::get('/contact', [HomeController::class, 'getContact'])->name('contact');
});

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/', [CustomersController::class, 'getHome'])->name('home');
    Route::get('/home', [CustomersController::class, 'getHome'])->name('home');

    // Đặt hàng
    Route::get('/place-order', [CustomersController::class, 'getPlaceOrder'])->name('place-order');
    Route::post('/place-order', [CustomersController::class, 'postPlaceOrder'])->name('place-order');
    Route::get('/place-order-success', [CustomersController::class, 'getPlaceOrderSuccess'])->name('place-order-success');

    // Xem và cập nhật trạng thái đơn hàng
    Route::get('/order', [CustomersController::class, 'getOrder'])->name('order');
    Route::get('/order/{id}', [CustomersController::class, 'getOrder'])->name('order.details');
    Route::post('/order/{id}', [CustomersController::class, 'postOrder'])->name('order.details');

    // Cập nhật thông tin tài khoản
    Route::get('/profile', [CustomersController::class, 'getProfile'])->name('profile');
    Route::post('/profile', [CustomersController::class, 'postProfile'])->name('profile'); // Đổi mật khẩu
    Route::get('/change-password', [CustomersController::class, 'getChangePassword'])->name('change-password');
    Route::post('/change-password', [CustomersController::class, 'postChangePassword'])->name('change-password');
});


Route::prefix('administrator')->name('administrator.')->middleware('role:administrator')->group(function () {
    // Trang chủ frontend
    Route::get('/', [AdministratorController::class, 'getHome'])->name('home');
    Route::get('/home', [AdministratorController::class, 'getHome'])->name('home');

    // Quản lý Loại sản phẩm
    Route::get('/categories', [CategoriesController::class, 'getList'])->name('categories');
    Route::get('/categories/add', [CategoriesController::class, 'getAdd'])->name('categories.add');
    Route::post('/categories/add', [CategoriesController::class, 'postAdd'])->name('categories.add');
    Route::get('/categories/update/{id}', [CategoriesController::class, 'getUpdate'])->name('categories.update');
    Route::post('/categories/update/{id}', [CategoriesController::class, 'postUpdate'])->name('categories.update');
    Route::get('/categories/delete/{id}', [CategoriesController::class, 'getDelete'])->name('categories.delete');
    Route::post('/categories/import', [CategoriesController::class, 'postImport'])->name('categories.import');
    Route::get('/categories/export', [CategoriesController::class, 'getExport'])->name('categories.export');

    // Quản lý Hãng sản xuất
    Route::get('/manufacturers', [ManufacturesController::class, 'getList'])->name('manufacturers');
    Route::get('/manufacturers/add', [ManufacturesController::class, 'getAdd'])->name('manufacturers.add');
    Route::post('/manufacturers/add', [ManufacturesController::class, 'postAdd'])->name('manufacturers.add');
    Route::get('/manufacturers/update/{id}', [ManufacturesController::class, 'getUpdate'])->name('manufacturers.update');
    Route::post('/manufacturers/update/{id}', [ManufacturesController::class, 'postUpdate'])->name('manufacturers.update');
    Route::get('/manufacturers/delete/{id}', [ManufacturesController::class, 'getDelete'])->name('manufacturers.delete');
    Route::post('/manufacturers/import', [ManufacturesController::class, 'postImport'])->name('manufacturers.import');
    Route::get('/manufacturers/export', [ManufacturesController::class, 'getExport'])->name('manufacturers.export');

    // Quản lý Sản phẩm
    Route::get('/products', [ProductsController::class, 'getList'])->name('products');
    Route::get('/products/add', [ProductsController::class, 'getAdd'])->name('products.add');
    Route::post('/products/add', [ProductsController::class, 'postAdd'])->name('products.add');
    Route::get('/products/update/{id}', [ProductsController::class, 'getUpdate'])->name('products.update');
    Route::post('/products/update/{id}', [ProductsController::class, 'postUpdate'])->name('products.update');
    Route::get('/products/delete/{id}', [ProductsController::class, 'getDelete'])->name('products.delete');
    Route::post('/products/import', [ProductsController::class, 'postImport'])->name('products.import');
    Route::get('/products/export', [ProductsController::class, 'getExport'])->name('products.export');

    // Quản lý Tình trạng Đơn hàng
    Route::get('/order-statuses', [OrderStatusController::class, 'getList'])->name('order_statuses');
    Route::get('/order-statuses/add', [OrderStatusController::class, 'getAdd'])->name('order_statuses.add');
    Route::post('/order-statuses/add', [OrderStatusController::class, 'postAdd'])->name('order_statuses.add');
    Route::get('/order-statuses/update/{id}', [OrderStatusController::class, 'getUpdate'])->name('order_statuses.update');
    Route::post('/order-statuses/update/{id}', [OrderStatusController::class, 'postUpdate'])->name('order_statuses.update');
    Route::get('/order-statuses/delete/{id}', [OrderStatusController::class, 'getDelete'])->name('order_statuses.delete');
    Route::post('/order-statuses/import', [OrderStatusController::class, 'postImport'])->name('order_statuses.import');
    Route::get('/order-statuses/export', [OrderStatusController::class, 'getExport'])->name('order_statuses.export');

    // Quản lý Đơn hàng
    Route::get('/orders', [OrdersController::class, 'getList'])->name('orders');
    Route::get('/orders/add', [OrdersController::class, 'getAdd'])->name('orders.add');
    Route::post('/orders/add', [OrdersController::class, 'postAdd'])->name('orders.add');
    Route::get('/orders/update/{id}', [OrdersController::class, 'getUpdate'])->name('orders.update');
    Route::post('/orders/update/{id}', [OrdersController::class, 'postUpdate'])->name('orders.update');
    Route::get('/orders/delete/{id}', [OrdersController::class, 'getDelete'])->name('orders.delete');

    // Quản lý Vai trò người dùng
    Route::get('/roles', [RolesController::class, 'getList'])->name('roles');
    Route::get('/roles/add', [RolesController::class, 'getAdd'])->name('roles.add');
    Route::post('/roles/add', [RolesController::class, 'postAdd'])->name('roles.add');
    Route::get('/roles/update/{id}', [RolesController::class, 'getUpdate'])->name('roles.update');
    Route::post('/roles/update/{id}', [RolesController::class, 'postUpdate'])->name('roles.update');
    Route::get('/roles/delete/{id}', [RolesController::class, 'getDelete'])->name('roles.delete');
    Route::post('/roles/import', [RolesController::class, 'postImport'])->name('roles.import');
    Route::get('/roles/export', [RolesController::class, 'getExport'])->name('roles.export');

    // Quản lý Tài khoản người dùng
    Route::get('/users', [UsersController::class, 'getList'])->name('users');
    Route::get('/users/add', [UsersController::class, 'getAdd'])->name('users.add');
    Route::post('/users/add', [UsersController::class, 'postAdd'])->name('users.add');
    Route::get('/users/update/{id}', [UsersController::class, 'getUpdate'])->name('users.update');
    Route::post('/users/update/{id}', [UsersController::class, 'postUpdate'])->name('users.update');
    Route::get('/users/delete/{id}', [UsersController::class, 'getDelete'])->name('users.delete');

    // Quản lý Thiết bị IoT
    Route::get('/iot-devices', [IoTDevicesController::class, 'getList'])->name('iot_devices');
    Route::get('/iot-devices/add', [IoTDevicesController::class, 'getAdd'])->name('iot_devices.add');
    Route::post('/iot-devices/add', [IoTDevicesController::class, 'postAdd'])->name('iot_devices.add');
    Route::get('/iot-devices/update/{id}', [IoTDevicesController::class, 'getUpdate'])->name('iot_devices.update');
    Route::post('/iot-devices/update/{id}', [IoTDevicesController::class, 'postUpdate'])->name('iot_devices.update');
    Route::get('/iot-devices/delete/{id}', [IoTDevicesController::class, 'getDelete'])->name('iot_devices.delete');

    // Quản lý chỉ số thiết bị
    Route::get('/device-metrics', [DeviceMetricController::class, 'getList'])->name('device_metrics');
    Route::get('/device-metrics/add', [DeviceMetricController::class, 'getAdd'])->name('device_metrics.add');
    Route::post('/device-metrics/add', [DeviceMetricController::class, 'postAdd'])->name('device_metrics.add');
    Route::get('/device-metrics/update/{id}', [DeviceMetricController::class, 'getUpdate'])->name('device_metrics.update');
    Route::post('/device-metrics/update/{id}', [DeviceMetricController::class, 'postUpdate'])->name('device_metrics.update');
    Route::get('/device-metrics/delete/{id}', [DeviceMetricController::class, 'getDelete'])->name('device_metrics.delete');

    // Quản lý ngưỡng cảnh báo
    Route::get('/alert-thresholds', [AlertThresholdsController::class, 'getList'])->name('alert_thresholds');
    Route::get('/alert-thresholds/add', [AlertThresholdsController::class, 'getAdd'])->name('alert_thresholds.add');
    Route::post('/alert-thresholds/add', [AlertThresholdsController::class, 'postAdd'])->name('alert_thresholds.add');
    Route::get('/alert-thresholds/update/{id}', [AlertThresholdsController::class, 'getUpdate'])->name('alert_thresholds.update');
    Route::post('/alert-thresholds/update/{id}', [AlertThresholdsController::class, 'postUpdate'])->name('alert_thresholds.update');
    Route::get('/alert-thresholds/delete/{id}', [AlertThresholdsController::class, 'getDelete'])->name('alert_thresholds.delete');

    //Quản lý Chủ đề
    Route::get('/topics', [TopicController::class, 'getList'])->name('topics');
    Route::get('/topics/add', [TopicController::class, 'getAdd'])->name('topics.add');
    Route::post('/topics/add', [TopicController::class, 'postAdd'])->name('topics.add');
    Route::get('/topics/update/{id}', [TopicController::class, 'getUpdate'])->name('topics.update');
    Route::post('/topics/update/{id}', [TopicController::class, 'postUpdate'])->name('topics.update');
    Route::get('/topics/delete/{id}', [TopicController::class, 'getDelete'])->name('topics.delete');

    //Quản lý Loại bài viết
    Route::get('/article-types', [ArticleTypeController::class, 'getList'])->name('article_types');
    Route::get('/article-types/add', [ArticleTypeController::class, 'getAdd'])->name('article_types.add');
    Route::post('/article-types/add', [ArticleTypeController::class, 'postAdd'])->name('article_types.add');
    Route::get('/article-types/update/{id}', [ArticleTypeController::class, 'getUpdate'])->name('article_types.update');
    Route::post('/article-types/update/{id}', [ArticleTypeController::class, 'postUpdate'])->name('article_types.update');
    Route::get('/article-types/delete/{id}', [ArticleTypeController::class, 'getDelete'])->name('article_types.delete');

    //Quản lý Tình trạng bài viết
    Route::get('/article-statuses', [ArticleStatusController::class, 'getList'])->name('article_statuses');
    Route::get('/article-statuses/add', [ArticleStatusController::class, 'getAdd'])->name('article_statuses.add');
    Route::post('/article-statuses/add', [ArticleStatusController::class, 'postAdd'])->name('article_statuses.add');
    Route::get('/article-statuses/update/{id}', [ArticleStatusController::class, 'getUpdate'])->name('article_statuses.update');
    Route::post('/article-statuses/update/{id}', [ArticleStatusController::class, 'postUpdate'])->name('article_statuses.update');
    Route::get('/article-statuses/delete/{id}', [ArticleStatusController::class, 'getDelete'])->name('article_statuses.delete');

    //Quản lý Bài viết
    Route::get('/articles', [ArticleController::class, 'getList'])->name('articles');
    Route::get('/articles/add', [ArticleController::class, 'getAdd'])->name('articles.add');
    Route::post('/articles/add', [ArticleController::class, 'postAdd'])->name('articles.add');
    Route::get('/articles/update/{id}', [ArticleController::class, 'getUpdate'])->name('articles.update');
    Route::post('/articles/update/{id}', [ArticleController::class, 'postUpdate'])->name('articles.update');
    Route::get('/articles/delete/{id}', [ArticleController::class, 'getDelete'])->name('articles.delete');

    //Quản lý Bình luận
    Route::get('/comments', [CommentController::class, 'getList'])->name('comments');
    Route::get('/comments/add', [CommentController::class, 'getAdd'])->name('comments.add');
    Route::post('/comments/add', [CommentController::class, 'postAdd'])->name('comments.add');
    Route::get('/comments/update/{id}', [CommentController::class, 'getUpdate'])->name('comments.update');
    Route::post('/comments/update/{id}', [CommentController::class, 'postUpdate'])->name('comments.update');
    Route::get('/comments/delete/{id}', [CommentController::class, 'getDelete'])->name('comments.delete');
    Route::get('/comments/censored/{id}', [CommentController::class, 'getCensored'])->name('comments.censored');
    Route::get('/comments/enabled/{id}', [CommentController::class, 'getEnabled'])->name('comments.enabled');
});

Route::prefix('saler')->name('saler.')->group(function () {
    Route::get('/', [SalerController::class, 'getHome'])->name('home');
    Route::get('/home', [SalerController::class, 'getHome'])->name('home');
    // Thêm các routes khác cho saler ở đây
});


Route::prefix('shipper')->name('shipper.')->group(function () {
    Route::get('/', [ShipperController::class, 'getHome'])->name('home');
    Route::get('/home', [ShipperController::class, 'getHome'])->name('home');
    // Thêm các routes khác cho shipper ở đây
});
