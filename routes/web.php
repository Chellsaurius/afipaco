<?php

use App\Http\Controllers\AmountsController;
use App\Http\Controllers\InspectorsController;
use App\Http\Controllers\LocalsController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\MerchantsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TianguisController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WarningsController;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;

Auth::routes(['register'=> false]); //evitar que el register esté activo

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('carcasa', [App\Http\Controllers\HomeController::class, 'carcasa'])->name('carcasa');


Route::middleware([isAdmin::class])->group(function() {

    Route::controller(AmountsController::class)->group(function() {
        Route::get('montos', 'index')->name('amounts.index');
        Route::post('montos', 'store')->name('montos.store');
        Route::get('nuevo_monto', 'nmonto')->name('nmontos');
        Route::get('activarMontoFiscal/{id}', 'enableAmount')->name('amount.enable');
        Route::get('desactivarMontoFiscal/{id}', 'disableAmount')->name('amount.disable');
    });

    Route::controller(MerchantsController::class)->group(function() {
        Route::get('registrarComerciante', 'index')->name('merchant.index');
        Route::post('guardarComerciante', 'saveMerchant')->name('merchant.saveNew');
        Route::get('registrarNuevoLocal/{merchant_curp}', 'registerNewLocal')->name('merchant.registerLocal');
        Route::post('registrarComercianteLocal/{curp}', 'saveMerchantLocal')->name('sMLocal');
        Route::get('comoBuscarComerciante', 'howMerchant')->name('merchant.how');
        Route::post('listaDeComerciantes', 'merchantList')->name('lComerciantes');
        Route::get('downloadQR/{merchant_id}', 'downloadQR')->name('merchant.dwnlqr');
        Route::get('darDeBaja/{id}', 'cancelMerchant')->name('merchant.cancel');
        Route::get('listadaDadosDeBaja', 'listDownMerchants')->name('merchant.downList');
        Route::get('darDeAlta/{id}', 'returningMerchant')->name('merchant.reactivate');
        Route::post('actualizarComerciante', 'updateMerchant')->name('merchant.update');
        Route::get('listaEspecífica/{id}', 'specificMerchantList')->name('merchant.specificList');
    });
    
    Route::controller(TianguisController::class)->group(function() {
        Route::get('listaTuianguis', 'index')->name('tianguis.index');
        Route::get('nuevo_tianguis', 'nTianguis')->name('nTianguis');
        Route::post('ntianguis', 'store')->name('tianguis.store');
        Route::get('darDeBajaTianguis/{id}', 'deactivateTianguis')->name('tianguis.deactivate');
        Route::post('actualizarTianguis', 'updateTianguis')->name('tianguis.update');
    });
    
    Route::controller(LocalsController::class)->group(function() {
        Route::get('listaLocales', 'index')->name('lLocales');
        Route::get('nuevoLocalT', 'nuevoLocalT')->name('nLocalT');
        Route::get('nuevoLocalA', 'nuevoLocalA')->name('nLocalA');
        Route::post('guardarLocal/', 'saveLocal')->name('sLocal');
        Route::post('actualizarLocal', 'updateLocal')->name('local.update');
        Route::get('darDeBajaLocal/{local_id}', 'cancelLocal')->name('local.cancel');
        Route::get('EditarLocal/{local_id}', 'getLocalDetails')->name('local.localDetails');
        Route::post('actualizarLocalEstatico', 'updateStaticLocal')->name('local.updateStaticLocal');
        Route::get('darDeBajaLugar/{local_id}', 'deactivateTPlace')->name('local.cancelTSpace');
        Route::post('nuevoLugar', 'addPlaceLocal')->name('local.addPlace');
        Route::post('editarLugar', 'updatePlace')->name('local.updatePlace');
        Route::post('editarMedidasDelLocal', 'updateLocalMeasurements')->name('local.updateLocalMeasurements');
    });
    
    Route::controller(PaymentsController::class)->group(function() {
        Route::post('listaPagos', 'index')->name('payment.list');
        Route::get('nuevoPago/{curp}/{registro}', 'newPayment')->name('payment.new');
        Route::post('guardarPago', 'savePayment')->name('payment.save');
        Route::get('localesPago/{curp}', 'localsPayment')->name('payment.locals');
        Route::get('ListaPagosPendientes', 'pendingPayments')->name('payments.pending');
        //Route::get('nuevoAdeudoPago/{curp}', 'newDuePayment')->name('payment.due');
        Route::get('downloadPDF/{id}','downloadPDF')->name('payments.dwnlpdf');
        Route::post('guardarFolio', 'saveFolioPayments')->name('payment.saveFolio');
        Route::get('comoBuscarPagos', 'howShowPayments')->name('payment.how');
        Route::get('cancelarPago/{id}', 'cancelPayment')->name('payment.cancel');
        Route::get('imprimirPago/{id}', 'downloadPayment')->name('payments.download');
        Route::post('guardarPagoOcasional', 'saveOcasionalPayment')->name('payment.saveOcationalPayment');
        Route::post('ajaxGuardarPago', 'ajaxSavePayment')->name('ajax.savePayment');
        Route::post('editarFolio', 'editFolioPayment')->name('payment.editFolio');
    });
    
    Route::controller(InspectorsController::class)->group(function(){
        Route::get('inspectores', 'index')->name('inspectors.index');
        Route::get('nInspector', 'nInspector')->name('inspector.new');
        Route::post('sInspector', 'saveInspector')->name('inspector.store');
        Route::get('bajaInspector/{id}', 'dischargeInspector')->name('inspector.discharge');
        Route::get('listaInspectoresDadosDeBaja', 'listDischargedInspectors')->name('inspector.dischargedList');
        Route::get('activarInspectorDadoDeBaja/{id}', 'activateDischargedInspector')->name('inspector.activate');
        Route::post('actualizarInspector', 'updateInspector')->name('inspector.update');
    });
    
    Route::controller(WarningsController::class)->group(function() {
        Route::get('listaApercibimientos', 'index')->name('warnings.list');
        Route::get('modificarApercibimiento/{id}', 'modifyWarning')->name('warning.remove');
        Route::get('listaApercibimientosEspecifica/{id}', 'especificWarning')->name('warnings.especificList');
    });

    Route::controller(ReportsController::class)->group(function() {
        Route::get('reportes', 'index')->name('report.index');
        Route::post('reporteDiario', 'dailyReport')->name('report.daily');
        Route::post('reportesPagos', 'paymentsReport')->name('report.payments');
        Route::post('reporteAcumulado', 'acumulatedReport')->name('report.acumulated');
        Route::post('generarReporte', 'generateReport')->name('report.generate');
        Route::post('generarReporteIngresos', 'showReport')->name('report.show');
        Route::post('reporteDiarioTianguis', 'excelDTReport')->name('report.excelDT');
        Route::post('ajaxTMesReporteDiario', 'ajaxTDRMonth')->name('ajax.getTDRMonth');
        Route::post('ajaxTDiaReporteDiario', 'ajaxTDRDay')->name('ajax.getTDRDay');
        Route::post('ajaxVPMesReporteDiario', 'ajaxVPDRMonth')->name('ajax.getVPDRMonth');
        Route::post('ajaxVPDiaReporteDiario', 'ajaxVPDRDay')->name('ajax.getVPDRDay');
        Route::get('ajaxSearchMerchant/{curp}', 'ajaxSearchMerchant')->name('ajax.searchMerchant');
        Route::get('ajaxReporteGeneral/{t}/{s}/{a}/{o}/{from}/{to}', 'ajaxGeneralReport')->name('ajax.generalReport');
        Route::post('ajaxReporteRápido', 'ajaxQuickReport')->name('ajax.quickReport');
        Route::post('ajaxOcationalMonthDailyReport', 'ajaxOcationalMonthDailyReport')->name('ajax.OMDR');
        Route::post('ajaxOcationalDayDailyReport', 'ajaxOcationalDayDailyReport')->name('ajax.ODDR');
    });

    Route::controller(MarketController::class)->group(function() {
        Route::get('Ubicaciones_de_centros_historicos', 'index')->name('maket.index');
        Route::get('registrar_nueva_ubicación', 'newMarket')->name('market.new');
        Route::post('guardarNuevaUbicación', 'saveMarket')->name('market.save');
        Route::post('editarUbicación', 'editMarket')->name('market.edit');
        Route::post('deshabilitarUbicación/{id}', 'disableMarket')->name('market.disable');
        Route::post('habilitarUbicación/{id}', 'enableMarket')->name('market.enable');
        Route::get('lista_de_lugares_deshabilitados', 'disabledMarketsList')->name('market.disabledList');
    });

});

Route::controller(WarningsController::class)->group(function() {
    Route::post('generarApercibimiento', 'generateWarning')->name('warnings.generate')->middleware('isAuth');
    
});

Route::controller(MerchantsController::class)->group(function() {
    Route::get('verComerciante/{curp}', 'inspectMerchant')->name('merchant.inspect')->middleware('isAuth');
    
});

Route::controller(UsersController::class)->group(function() {
    Route::get('cambiarContrasena', 'index')->name('cambiarContrasena')->middleware('isAuth');
    Route::post('guardarContrasena', 'changePass')->name('guardarContrasena')->middleware('isAuth');
});


Route::get('offline', function() {
    return view('vendor/laravelpwa/offline.blade.php');
});
