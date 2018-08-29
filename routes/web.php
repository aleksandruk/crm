<?php
// Route::get('/', function () { return redirect('/admin/home'); });
Route::get('/', function () {
    return redirect('/admin/home');
});
// // Authentication Routes...
// $this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
// $this->post('login', 'Auth\LoginController@login')->name('auth.login');
// $this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// // Change Password Routes...
// $this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
// $this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// // Password Reset Routes...
// $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
// $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
// $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// $this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');


Auth::routes();

//Route::get('/home', 'HomeController@index');
Route::get('/admin/logout', 'Auth\LoginController@adminLogout')->name('admin.logout');


Route::prefix('store')->group(function() {
    Route::get('/home', 'StoreController@index')->name('store.dashboard');
    Route::get('/login', 'Auth\StoreLoginController@showLoginForm')->name('store.login');
    Route::post('/login', 'Auth\StoreLoginController@login')->name('store.login.submit');
    Route::get('/logout', 'Auth\StoreLoginController@logout')->name('store.logout');

    Route::get('/dispositions/packed', 'Store\DispositionsController@packed')->name('store.dispositions.packed');
    Route::get('/dispositions/all_packs', 'Store\DispositionsController@allPacks')->name('store.dispositions.all_packs');
    Route::get('/dispositions/my_packs', 'Store\DispositionsController@myPacks')->name('dispositions.my_packs');

    Route::get('/dispositions/get_parcels', 'Store\DispositionsController@getParcels')->name('dispositions.get_parcels');
    Route::patch('/dispositions/driver_update', 'Store\DispositionsController@driverUpdate')->name('dispositions.driver_update');
    Route::get('/dispositions/{id}/driver_report', 'Store\DispositionsController@driverReport')->name('dispositions.driverReport');
    Route::patch('dispositions/driver_report_update', 'Store\DispositionsController@driverReportUpdate')->name('dispositions.driver_report_update'); 

    Route::get('/dispositions/all_parcels', 'Store\DispositionsController@allParcels')->name('dispositions.all_parcels');
    Route::get('dispositions/my_parcels', 'Store\DispositionsController@myParcels')->name('dispositions.my_parcels');

    Route::get('/dispositions/shipped_parcels', 'Store\DispositionsController@shippedParcels')->name('dispositions.shipped_parcels');
    Route::get('/dispositions/{id}/info', 'Store\DispositionsController@info')->name('dispositions.info');
    Route::patch('/dispositions/info_update', 'Store\DispositionsController@infoUpdate')->name('dispositions.info_update');
    Route::resource('/dispositions','Store\DispositionsController');
    
});

Route::prefix('admin')->group(function() {
    Route::get('/home', 'HomeController@index');
    Route::resource('abilities', 'Admin\AbilitiesController');
    Route::post('abilities_mass_destroy', ['uses' => 'Admin\AbilitiesController@massDestroy', 'as' => 'abilities.mass_destroy']);
    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    Route::get('dispositions/all_packs', ['uses' => 'Admin\DispositionsController@allPacks', 'as' => 'dispositions.all_packs']);
    Route::get('dispositions/my_packs', ['uses' => 'Admin\DispositionsController@myPacks', 'as' => 'dispositions.my_packs']);
    Route::get('dispositions/packed', ['uses' => 'Admin\DispositionsController@packed', 'as' => 'dispositions.packed']);

    Route::get('dispositions/get_parcels',['uses' => 'Admin\DispositionsController@getParcels', 'as' => 'dispositions.get_parcels']);
    Route::patch('dispositions/driver_update', 'Admin\DispositionsController@driverUpdate')->name('dispositions.driver_update');
    Route::get('dispositions/{id}/driver_report',['uses' => 'Admin\DispositionsController@driverReport', 'as' => 'dispositions.driverReport']);
    Route::patch('dispositions/driver_report_update', 'Admin\DispositionsController@driverReportUpdate')->name('dispositions.driver_report_update'); 

    Route::get('dispositions/all_parcels', ['uses' => 'Admin\DispositionsController@allParcels', 'as' => 'dispositions.all_parcels']);
    Route::get('dispositions/my_parcels', ['uses' => 'Admin\DispositionsController@myParcels', 'as' => 'dispositions.my_parcels']);

    Route::get('dispositions/shipped_parcels', ['uses' => 'Admin\DispositionsController@shippedParcels', 'as' => 'dispositions.shipped_parcels']);
    Route::get('dispositions/{id}/info',['uses' => 'Admin\DispositionsController@info', 'as' => 'dispositions.info']);
    Route::patch('dispositions/info_update', 'Admin\DispositionsController@infoUpdate')->name('dispositions.info_update');
    Route::resource('dispositions','Admin\DispositionsController');


});

   