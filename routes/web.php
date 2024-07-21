<?php

use App\Http\Controllers\AsignarController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VentasController;
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
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', [DashController::class, 'index']);
    Route::get('/profile', [profileController::class, 'profile']);
    Route::resource('/cliente', ClienteController::class)->names('cliente');
    Route::resource('/proveedor', ProveedorController::class)->names('proveedor');
    Route::resource('/productos', ProductoController::class)->names('producto');
    Route::get('/compras/byProveedor', [CompraController::class, 'byProveedor'])->name('compras.byProveedor');

    Route::resource('/compras', CompraController::class)->names('compra');
    Route::resource('/venta', VentasController::class)->names('venta');
    Route::resource('/categoria', CategoriaController::class)->names('categoria');

    Route::get('/change_status/productos/{producto}', [ProductoController::class, 'changeStatus'])->name('productstatus');
    Route::get('/change_status/ventas/{venta}', [VentasController::class, 'changeStatus'] )->name('ventastatus');
    Route::get('/change_status/compras/{compra}', [CompraController::class, 'changeStatus'])->name('comprastatus');

    Route::get('/compras/pdf/{compra}', [CompraController::class, 'pdf'])->name('compra.pdf');
    Route::get('/ventas/pdf/{venta}', [VentasController::class, 'pdf'])->name('venta.pdf');

    Route::get('/ventas/reporte_dia', [ReportController::class, 'reporte_dia'])->name('reporte.dia');
    Route::get('/ventas/reporte_fecha', [ReportController::class, 'reporte_fecha'])->name('reporte.fecha');

    route::post('/user/report_resultado', [ReportController::class,'reporte_resultado'])->name('reporte.resultado');

    Route::resource('/roles', RoleController::class)->names('roles');
    Route::resource('/permisos', PermisoController::class)->names('permisos');
    Route::resource('/asignar', AsignarController::class)->names('asignar');

    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');


});
