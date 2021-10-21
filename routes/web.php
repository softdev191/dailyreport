<?php

use App\Http\Services\ReportService;
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

Route::get('/', function () {
    if (Auth::check())
        return redirect('/home');
    else
        return redirect('/login');
})->name('login');

Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login');

Route::group(['middleware'=>'auth'], function() {
    Route::get('/logout', 'LoginController@logout');
    Route::get('/home', 'ReportController@index');
    Route::post('/report', 'ReportController@report');
    Route::post('/report_detail', 'ReportController@report_detail');
    Route::post('/report_print', 'ReportController@report_print');
    Route::post('/add_location', 'ReportController@add_location');
    Route::post('/delete_location', 'ReportController@delete_location');
    Route::post('/delete_report', 'ReportController@delete_report');
    Route::post('/change_location', 'ReportController@change_location');
    Route::post('/complete_location', 'ReportController@complete_location');
    Route::post('/rollback_complete', 'ReportController@rollback_complete');
    Route::post('/get_location_status', 'ReportController@get_location_status');
    Route::get('/report_print', 'ReportController@report_print');
    Route::post('/get_spot_list', 'ReportController@get_spot_list');
    Route::post('/get_miss_list', 'ReportController@get_miss_list');
    // Route::post('/get_type_equip_list', 'MasterController@get_type_equip_list');
    // Route::post('/get_worker_price', 'MasterController@get_worker_price');
    // Route::post('/get_equip_price', 'MasterController@get_equip_price');
    Route::post('/save_report_detail', 'ReportController@save_report_detail');
    Route::post('/get_report_list', 'ReportController@get_report_list');
    Route::post('/change_location_editor', 'ReportController@change_location_editor');
    Route::post('/create_report', 'ReportController@create_report');
});

Route::group(['middleware'=>'auth'], function() {
    Route::get('/master', 'MasterController@index');
    Route::post('/add_user', 'LoginController@add_user');
    Route::post('/get_user_list', 'LoginController@get_user_list');
    Route::post('/get_user_info', 'LoginController@get_user_info');
    Route::post('/delete_user', 'LoginController@delete_user');

    // Worker
    Route::post('/add_personal', 'PersonalController@store');
    Route::post('/get_personal_list', 'PersonalController@get_personal_list');
    Route::post('/get_ordered_personals', 'PersonalController@get_ordered_personals');
    Route::post('/get_personal_hidden_list', 'PersonalController@get_personal_hidden_list');
    Route::post('/get_personal_info', 'PersonalController@get');
    Route::post('/delete_personal', 'PersonalController@delete_personal');
    Route::post('/get_worker_price', 'PersonalController@get_worker_price');
    Route::post('/edit_personal', 'PersonalController@edit');
    Route::post('/show_worker', 'PersonalController@show');
    Route::post('/change_position', 'PersonalController@reorder');

    Route::post('/get_price_list', 'PersonalController@get_worker_prices');
    Route::post('/get_price', 'PersonalController@get_price');
    Route::post('/edit_price', 'PersonalController@edit_price');
    Route::post('/delete_price', 'PersonalController@delete_price');
    // Company
    Route::post('/add_company', 'CompanyController@add_company');
    Route::post('/get_company_list', 'CompanyController@get_company_list');
    Route::post('/get_company_info', 'CompanyController@get_company_info');
    Route::post('/delete_company', 'CompanyController@delete_company');
    //type
    Route::post('/add_type', 'TypeController@add_type');
    Route::post('/get_type_list', 'TypeController@get_type_list');
    Route::post('/get_type_info', 'TypeController@get_type_info');
    Route::post('/delete_type', 'TypeController@delete_type');
    //equip
    Route::post('/add_equipment', 'EquipmentController@add_equipment');
    Route::post('/get_equipment_list', 'EquipmentController@get_equipment_list');
    Route::post('/get_equipment_info', 'EquipmentController@get_equipment_info');
    Route::post('/delete_equipment', 'EquipmentController@delete_equipment');
    Route::post('/get_equipment_price_list', 'EquipmentController@get_equipment_price_list');
    Route::post('/change_equipment_price', 'EquipmentController@change_equipment_price');
    Route::post('/get_type_equip_list', 'EquipmentController@get_type_equip_list');
    Route::post('/get_equip_price', 'EquipmentController@get_equip_price');
    Route::post('/get_equipment_price_list_detail', 'EquipmentController@get_equipment_price_list_detail');
    Route::post('/get_equipment_price_one', 'EquipmentController@get_equipment_price_one');
    Route::post('/delete_equip_price', 'EquipmentController@delete_equip_price');
    //tax
    Route::post('/set_excise_info', 'TaxController@set_excise_info');
    Route::get('/get_taxes_list', 'TaxController@get_taxes_list');
    Route::delete('/delete_tax/{id}', 'TaxController@delete_tax');
    Route::post('/update_tax', 'TaxController@update_tax');
});
