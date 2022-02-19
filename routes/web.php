<?php

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

//Route::get('/compra', 'FrontController@compra_view');
//Route::get('/compra-test', 'FrontController@compra_view_test');

// ------------------------------------------------------
// Rutas de Front
// ------------------------------------------------------
// Route::get('/', function () { return view('mantenimiento'); });
Route::get('/', 'FrontController@index_view') -> name('index');
Route::get('/home', 'FrontController@index_view') -> name('index');
Route::get('/compra/paquete/{id}', 'FrontController@compra_view') -> name('comprar') -> middleware('auth');
Route::post('/compra/save', 'PurchaseController@compra_update_data') -> middleware('auth')->middleware('auth_front');
Route::post('/compra/save/conekta', 'PurchaseController@compra_update_data_conekta') -> name('comprarConecta') -> middleware('auth')->middleware('auth_front');
Route::get('/complete/{free?}', 'FrontController@complete_view') -> name('completado') -> middleware('auth');
Route::get('/paquetes', 'FrontController@paquetes_view');
Route::get('/perfil', 'FrontController@perfil_view') -> name('profile') -> middleware('auth')->middleware('auth_front');
Route::put('/perfil/datos/update/{id}', 'CustomerController@update') -> name('updateDatosCustomer') -> middleware('auth');
Route::post('/perfil/clase/cancelar', 'FrontController@ReservationDestroy') -> name('cancelarReservacion') -> middleware('auth');
Route::get('/clases', 'FrontController@clases_view'); 
Route::get('/teamdetalle/{id}', 'FrontController@teamdetalle_view')->name('front.team.detalle');; 
Route::get('/blog', 'FrontController@blog_view'); 
Route::get('/blogdetalle', 'FrontController@blogdetalle_view'); 
Route::get('/terminos', 'FrontController@terminos_view');
Route::get('/clases', 'FrontController@clases_view');
Route::get('/teamdetalle', 'FrontController@teamdetalle_view');
Route::get('/ubicacion', 'FrontController@ubicacion_view');
Route::get('/reservar/{page?}', 'FrontController@reservacion_view')->name('front.reservar');
Route::get('/reservar/clase/detalle/{id}', 'FrontController@reservacion_deta_view')->name('front.reservar.detalle');
Route::post('/reserve', 'FrontController@createReservation')->name('reserve');
// Route::post('/reserve', 'ReservationController@store')->name('reserve')->middleware('auth_front');
Route::get('/team', 'FrontController@team_view');
Route::post('/register/customer', 'Auth\RegisterController@register') -> name('registerCustomer');
//Route::get('/send/mail', 'FrontController@testCorreo');
// Route::get('/send/mail2', 'FrontController@testCorreo2');

// ------------------------------------------------------
// Rutas Envio de correos
// ------------------------------------------------------
Route::post('/ubicacion/contacto/send', 'MessageController@mail_contacto') -> name('mail.contacto');


// ------------------------------------------------------
// Rutas customs Auth
// ------------------------------------------------------
Route::post('/login', 'Auth\LoginController@login')->name('login')->middleware('seamlesslogin');
Route::post('/password/reset', 'Auth\PasswordController@reset');
// Auth::routes();
// Route::get('/', 'Auth\LoginController@loginForm')->name('panel.login_clientes');
// Route::get('/rememberme', 'ConsumerController@forgotPassword')->name('panel.user.rememberme');
// Route::post('password/email', 'ConsumerController@RecoveryMail')->name('panel.user.reset.mail');
// Route::get('password/email/{token?}', 'ConsumerController@RecoveryForm');


// ------------------------------------------------------
// Ruta para cerrar sesión
// ------------------------------------------------------
//ruta para enviar el correo de recuperacion
//ruta para el formulario de cambio de contraseña
// Route::get('password/email/{token?}', 'ConsumerController@RecoveryForm');



//Ruta para cerrar sesión
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('admin/logout', 'Auth\LoginController@logout')->name('admin.logout');
Route::get('admin/login', 'Auth\LoginController@login_panel') -> name('login.admin');
Route::get('panel','FrontController@redirectLogin')->name('login.panel');


// ------------------------------------------------------
// Rutas Back
// ------------------------------------------------------
Route::name('admin.')->group(function () {
    Route::post('admin/cupon/aplicar', 'CuponController@applyCupon') -> name('cupon.apply');
    Route::middleware(['auth', 'auth_panel'])->group(function () {
        Route::name('customer.')->group(function () {
            Route::get('admin/clientes', 'CustomerController@index')->name('list');
            Route::get('admin/clientes/array-data', 'CustomerController@data') -> name('array.data');
            Route::get('admin/cliente/create/{clase?}', 'CustomerController@create') -> name('create');
            Route::get('admin/cliente/editar/{id}', 'CustomerController@edit') -> name('edit');
            Route::get('admin/cliente/preview/{id}', 'CustomerController@preview') -> name('preview');

            Route::post('admin/cliente/insert', 'CustomerController@store') -> name('insert');

            Route::put('admin/cliente/update/{id}', 'CustomerController@update') -> name('update');
            Route::put('admin/cliente/change-status', 'CustomerController@changeStatus') -> name('change.status');
            Route::delete('admin/cliente/delete', 'CustomerController@destroy') -> name('delete');
        });
        Route::name('instructor.')->group(function () {
            Route::get('admin/instructores', 'InstructorController@index')->name('list');
            Route::get('admin/instructores/array-data', 'InstructorController@data') -> name('array.data');
            Route::get('admin/instructor/create', 'InstructorController@create') -> name('create');
            Route::get('admin/instructor/editar/{id}', 'InstructorController@edit') -> name('edit');

            Route::post('admin/instructor/insert', 'InstructorController@store') -> name('insert');

            Route::put('admin/instructor/update/{id}', 'InstructorController@update') -> name('update');
            Route::put('admin/instructor/change-status', 'InstructorController@changeStatus') -> name('change.status');
            Route::delete('admin/instructor/delete', 'InstructorController@destroy') -> name('delete');
        });

        Route::name('package.')->group(function () {
            Route::get('admin/paquetes', 'PackageController@index')->name('list');
            Route::get('admin/paquetes/array-data', 'PackageController@data') -> name('array.data');
            Route::get('admin/paquete/create', 'PackageController@create') -> name('create');
            Route::get('admin/paquete/editar/{id}', 'PackageController@edit') -> name('edit');

            Route::post('admin/paquete/insert', 'PackageController@store') -> name('insert');

            Route::put('admin/paquete/update/{id}', 'PackageController@update') -> name('update');
            Route::put('admin/paquete/change-status', 'PackageController@changeStatus') -> name('change.status');
            Route::delete('admin/paquete/delete', 'PackageController@destroy') -> name('delete');
        });

        Route::name('lesson.')->group(function () {
            Route::get('admin/clases', 'LessonController@index')->name('list');
            Route::get('admin/clases/array-data', 'LessonController@data') -> name('array.data');
            Route::get('admin/clase/create', 'LessonController@create') -> name('create');
            Route::get('admin/clase/editar/{id}', 'LessonController@edit') -> name('edit');

            Route::post('admin/clase/insert', 'LessonController@store') -> name('insert');

            Route::put('admin/clase/update/{id}', 'LessonController@update') -> name('update');
            Route::put('admin/clase/change-status', 'LessonController@changeStatus') -> name('change.status');
            Route::delete('admin/clase/delete', 'LessonController@destroy') -> name('delete');


            Route::get('admin/clase/mats/{id}', 'LessonController@checkLesson') -> name('check.class');

        });

        Route::name('purchase.')->group(function () {
            Route::get('admin/ventas', 'PurchaseController@index')->name('list');
            Route::get('admin/ventas/array-data', 'PurchaseController@data') -> name('array.data');
            Route::get('admin/venta/create', 'PurchaseController@create') -> name('create');
            Route::get('admin/venta/editar/{id}', 'PurchaseController@edit') -> name('edit');
            Route::get('admin/venta/reset/dates', 'PurchaseController@updatePurchaseAnyDate') -> name('reset.dates');

            Route::post('admin/venta/insert', 'PurchaseController@store') -> name('insert');

            Route::put('admin/venta/update/{id}', 'PurchaseController@update') -> name('update');
            Route::put('admin/venta/change-status', 'PurchaseController@changeStatus') -> name('change.status');
            Route::delete('admin/venta/delete', 'PurchaseController@destroy') -> name('delete');
        });

        Route::name('cupon.')->group(function () {
            Route::get('admin/cupones', 'CuponController@index')->name('list');
            Route::get('admin/cupones/array-data', 'CuponController@data') -> name('array.data');
            Route::get('admin/cupon/create', 'CuponController@create') -> name('create');
            Route::get('admin/cupon/editar/{id}', 'CuponController@edit') -> name('edit');

            Route::post('admin/cupon/insert', 'CuponController@store') -> name('insert');
            Route::put('admin/cupon/update/{id}', 'CuponController@update') -> name('update');
            Route::put('admin/cupon/change-status', 'CuponController@changeStatus') -> name('change.status');
            Route::delete('admin/cupon/delete', 'CuponController@destroy') -> name('delete');
        });

        Route::name('mat.')->group(function () {
            Route::get('admin/tapetes', 'MatController@index')->name('list');
            Route::get('admin/tapetes/array-data', 'MatController@data') -> name('array.data');

            Route::put('admin/tapete/change-status', 'MatController@changeStatus') -> name('change.status');
        });

        Route::name('reservations.')->group(function () {
            Route::get('admin/reservations', 'ReservationController@index')->name('list');
            Route::get('admin/reservations/array-data', 'ReservationController@data') -> name('array.data');
            Route::get('admin/reservations/create', 'ReservationController@create') -> name('create');
            Route::get('admin/reservations/mats/{id}', 'ReservationController@mats') -> name('mats');
            Route::post('admin/reservations/new', 'ReservationController@storeAdmin') -> name('store.admin');
            Route::get('admin/reservations/cancel/{iduser}/{id}', 'ReservationController@destroy') -> name('delete');
            Route::put('admin/reservations/change-status', 'ReservationController@changeStatus') -> name('change.status');

        });

        Route::name('accounts.') -> group(function(){
            Route::get('admin/accounts', 'AdminController@index')->name('list');
            Route::get('admin/accounts/array-data', 'AdminController@data');
            Route::get('admin/accounts/create', 'AdminController@create')->name('create');
            Route::post('admin/accounts/store', 'AdminController@store')->name('store');
            Route::get('admin/accounts/{id}', 'AdminController@edit')->name('edit');
            Route::post('admin/accounts/update', 'AdminController@update')->name('update');
        });
        Route::name('rol.') -> group(function(){
            Route::get('admin/rol', 'RolController@rol_index')->name('list');
            Route::get('admin/rol/array-data', 'RolController@rol_data');
            Route::get('admin/rol/create', 'RolController@rol_create')->name('create');
            Route::post('admin/rol/store', 'RolController@rol_store')->name('store');
            Route::get('admin/rol/{rol}', 'RolController@rol_edit')->name('edit');
            Route::post('admin/rol/update', 'RolController@rol_update')->name('update');
        });
        Route::name('calendar.') -> group(function(){
            Route::get('admin/calendario', 'CalendarController@index')->name('list');
            Route::get('admin/calendario/instructor/dia/{fecha}', 'CalendarController@listInstructorPerDayParse');
            Route::get('admin/calendario/asistencia/{id_lesson}', 'CalendarController@asistenciaList')->name('asistencia.list');
            Route::get('admin/calendario/asistencia/clases/array-data', 'CalendarController@dataAsistencia');
            Route::get('admin/calendario/asistencia/exportar', 'CalendarController@dataAsistencia');
            Route::get('admin/calendario/asistencia/exportar/array-data', 'CalendarController@dataAsistencia');

            Route::post('admin/calendario/lessons/semana/{start}/{end}', 'CalendarController@listLessonsAndInstructors');
            Route::put('admin/calendario/reservacion/change-status', 'ReservationController@paseLista') -> name('reservation.change.status');

        });
    });
});

Route::get('password/confirm','Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm','Auth\ConfirmPasswordController@confirm')->name('password.confirm');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
