<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'companies'], function() {
    Route::get('/', 'CompanyController@index')->name('company.index');
    Route::post('/', 'CompanyController@store')->name('company.store');
    Route::get('/{company}', 'CompanyController@show')->name('company.show');
    Route::put('/{company}', 'CompanyController@update')->name('company.update');
    Route::delete('/{company}', 'CompanyController@destroy')->name('company.destroy');
});

Route::group(['prefix' => 'customers'], function() {
    Route::get('/', 'CustomerController@index')->name('customer.index');
    Route::post('/', 'CustomerController@store')->name('customer.store');
    Route::get('/{customer}', 'CustomerController@show')->name('customer.show');
    Route::put('/{customer}', 'CustomerController@update')->name('customer.update');
    Route::delete('/{customer}', 'CustomerController@destroy')->name('customer.destroy');
});

Route::get('/company-list', 'CompanyListController@index')->name('company-list.index');
Route::put('/transfer-data', 'TransferDataController@update')->name('transfer-data.update');

Route::group(['prefix' => 'abusers/companies'], function () {
    Route::get('/', 'AbuserCompanyController@index')->name('abuser-company.index');
    Route::get('/{company}/customers', 'AbuserCustomerController@index')->name('abuser-customer.index');
});

