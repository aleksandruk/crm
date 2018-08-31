<?php
Route::get('/', function () {
    return redirect('/admin/home');
});

Auth::routes();

Route::get('/admin/logout', 'Auth\LoginController@adminLogout')->name('admin.logout');


Route::prefix('store')->group(function() {
    Route::get('/home', 'StoreController@index')->name('store.dashboard');
    Route::get('/login', 'Auth\StoreLoginController@showLoginForm')->name('store.login');
    Route::post('/login', 'Auth\StoreLoginController@login')->name('store.login.submit');
    Route::get('/logout', 'Auth\StoreLoginController@logout')->name('store.logout');

    Route::get('/dispositions/packed', 'Store\DispositionsController@packed')->name('store.dispositions.packed');
    Route::get('/dispositions/all_packs', 'Store\DispositionsController@allPacks')->name('store.dispositions.all_packs');
    Route::get('/dispositions/my_packs', 'Store\DispositionsController@myPacks')->name('store.dispositions.my_packs');

    Route::get('/dispositions/get_parcels', 'Store\DispositionsController@getParcels')->name('store.dispositions.get_parcels');
    Route::patch('/dispositions/driver_update', 'Store\DispositionsController@driverUpdate')->name('store.dispositions.driver_update');
    Route::get('/dispositions/{id}/driver_report', 'Store\DispositionsController@driverReport')->name('store.dispositions.driverReport');
    Route::patch('dispositions/driver_report_update', 'Store\DispositionsController@driverReportUpdate')->name('store.dispositions.driver_report_update'); 

    Route::get('/dispositions/all_parcels', 'Store\DispositionsController@allParcels')->name('store.dispositions.all_parcels');
    Route::get('/dispositions/my_parcels', 'Store\DispositionsController@myParcels')->name('store.dispositions.my_parcels');

    Route::get('/dispositions/shipped_parcels', 'Store\DispositionsController@shippedParcels')->name('store.dispositions.shipped_parcels');
    Route::get('/dispositions/{id}/info', 'Store\DispositionsController@info')->name('store.dispositions.info');
    Route::patch('/dispositions/info_update', 'Store\DispositionsController@infoUpdate')->name('store.dispositions.info_update');
    Route::resource('/dispositions', 'Store\DispositionsController', [
        'as' => 'store'
    ]);
    
});

Route::prefix('admin')->group(function() {
    Route::get('/home', 'HomeController@index')->name('admin.dashboard');
    Route::resource('/abilities', 'Admin\AbilitiesController', [
        'as' => 'admin'
    ]);
    Route::post('/abilities_mass_destroy', 'Admin\AbilitiesController@massDestroy')->name('admin.abilities.mass_destroy');
    Route::resource('/roles', 'Admin\RolesController', [
        'as' => 'admin'
    ]);
    Route::post('/roles_mass_destroy', 'Admin\RolesController@massDestroy')->name('admin.roles.mass_destroy');
    Route::resource('/users', 'Admin\UsersController', [
        'as' => 'admin'
    ]);
    Route::post('/users_mass_destroy', 'Admin\UsersController@massDestroy')->name('admin.users.mass_destroy');

    Route::get('/dispositions/all_packs', 'Admin\DispositionsController@allPacks')->name('admin.dispositions.all_packs');
    Route::get('/dispositions/my_packs', 'Admin\DispositionsController@myPacks')->name('admin.dispositions.my_packs');
    Route::get('/dispositions/packed', 'Admin\DispositionsController@packed')->name('admin.dispositions.packed');

    Route::get('/dispositions/get_parcels', 'Admin\DispositionsController@getParcels')->name('admin.dispositions.get_parcels');
    Route::patch('/dispositions/driver_update', 'Admin\DispositionsController@driverUpdate')->name('admin.dispositions.driver_update');
    Route::get('/dispositions/{id}/driver_report', 'Admin\DispositionsController@driverReport')->name('admin.dispositions.driverReport');
    Route::patch('/dispositions/driver_report_update', 'Admin\DispositionsController@driverReportUpdate')->name('admin.dispositions.driver_report_update'); 

    Route::get('/dispositions/all_parcels', 'Admin\DispositionsController@allParcels')->name('admin.dispositions.all_parcels');
    Route::get('/dispositions/my_parcels', 'Admin\DispositionsController@myParcels')->name('admin.dispositions.my_parcels');

    Route::get('/dispositions/shipped_parcels', 'Admin\DispositionsController@shippedParcels')->name('admin.dispositions.shipped_parcels');
    Route::get('/dispositions/{id}/info', 'Admin\DispositionsController@info')->name('admin.dispositions.info');
    Route::patch('/dispositions/info_update', 'Admin\DispositionsController@infoUpdate')->name('admin.dispositions.info_update');
    Route::resource('/dispositions', 'Admin\DispositionsController', [
        'as' => 'admin'
    ]);
});

   