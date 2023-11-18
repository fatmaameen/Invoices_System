<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\Invoices_ReportController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/invoices' ,InvoicesController::class,[
    'names'=>[
     'index'=>'invoices.index',
     'create'=>'invoices.create',
     'store'=>'invoices.store',
'update'=>'invoices.update'
    ]
]);
Route::get('invoices/edit/{id}' ,[InvoicesController::class ,'edit'])->name('edit');
Route::get('invoices/delete/{id}' ,[InvoicesController::class ,'destroy'])->name('delete');
Route::any('invoices/show/{id}' ,[InvoicesController::class ,'show'])->name('status_show');
Route::any('invoices/status/{id}' ,[InvoicesController::class ,'status_update'])->name('status_update');
/////////////////////////////////////////////////
Route::get('invoices_paid' ,[InvoicesController::class ,'invoices_paid'])->name('invoices_paid');
Route::get('invoices_unpaid' ,[InvoicesController::class ,'invoices_unpaid'])->name('invoices_unpaid');
Route::get('invoices_partial' ,[InvoicesController::class ,'invoices_partial'])->name('invoices_partial');
Route::get('invoices_archive' ,[ArchiveController::class ,'index'])->name('invoices_archive');
Route::any('no_archive/{id}' ,[ArchiveController::class ,'update'])->name('no_archive');
Route::any('forse_delete/{id}' ,[ArchiveController::class ,'destroy'])->name('forse_delete');
///////////////////////////////////////////////////
Route::any('print_invoice/{id}' ,[InvoicesController::class ,'print_invoice'])->name('print_invoice');
Route::get('section/{id}' ,[InvoicesController::class,'getproducts']);
Route::resource('sections' ,SectionsController::class,[
    'names'=>[
     'index'=>'sections.index',
     'store'=>'sections.store',
     'update'=>'sections.update',
     'destroy'=>'sections.destroy'
    ]
]);
Route::resource('attachments' ,invoice_attachments::class,[
    'names'=>[

     'store'=>'attachments.store',

    ]
]);
Route::resource('/products' ,ProductController::class,[
    'names'=>[
        'index'=>'products.index',
        'store'=>'products.store',
        'update'=>'products.update',
        'destroy'=>'products.destroy',
]]);

Route::get('InvoicesDetails/{id}',[InvoicesDetailsController::class,'edit'])->name('InvoicesDetails');
Route::get('View_file/{file_name}/{invoice_number}',[InvoicesDetailsController::class,'open_file'])->name('View_file');
Route::get('download/{file_name}/{invoice_number}',[InvoicesDetailsController::class,'download'])->name('download');
Route::post('delete_file/{file_name}/{invoice_number}',[InvoicesDetailsController::class,'destroy'])->name('delete_file');

/////////////////////////////////////////////////////////////////////////

Route::group(['middleware'=>['auth']] ,function(){

Route::resource('roles' ,RoleController::class);
Route::resource('users' ,UserController::class);

});

Route::get('invoices_report' ,[Invoices_ReportController::class ,'index'])->name('invoices_report');
Route::any('Search_invoices' ,[Invoices_ReportController::class ,'Search_invoices'])->name('Search_invoices');
// Route::get('invoices_report' ,[Invoices_ReportController::class ,'index'])->name('invoices_report');




Route::get('/{page}', [AdminController::class,'index']);
