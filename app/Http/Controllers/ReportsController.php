<?php

namespace App\Http\Controllers;

use App\Models\Merchants;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class ReportsController extends Controller
{
    public function index()
    {
        $tyears = Payments::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->where('payment_status', 1)
            ->where('payment_category', 'Tianguista')
            ->get();
        
        $tyears = $tyears->sortDesc();
        
        $vpyears = Payments::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->where('payment_status', 1)
            ->where('payment_category', 'Semifijo')
            ->orWhere('payment_status', 1)
            ->where('payment_category', 'Ambulante')
            ->get();
        
        $vpyears = $vpyears->sortDesc();
        
        $tars = Payments::select('created_at')
            ->where('payment_status', 1)
            ->where('payment_category', 'Tianguista')
            // ->limit(10)
            ->first();

        $tarf = Payments::select('created_at')
            ->where('payment_category', 'Tianguista')
            ->where('payment_status', 1)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $vpars = Payments::select('created_at')
            ->where('payment_category', 'Semifijo')
            ->where('payment_status', 1)
            ->orWhere('payment_category', 'Ambulante')
            ->where('payment_status', 1)
            ->orderBy('created_at', 'asc')
            ->first();
        
        $vparf = Payments::select('created_at')
            ->where('payment_category', 'Semifijo')
            ->where('payment_status', 1)
            ->orWhere('payment_category', 'Ambulante')
            ->where('payment_status', 1)
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->first();

        $ocationalDailyYear = Payments::select(DB::raw('YEAR(created_at) as year'))
            ->where('payment_category', 'Ocasional')
            ->where('payment_status', 1)
            ->distinct()
            ->get();

        $ocationalDailyYear = $ocationalDailyYear->sortDesc(); 

        $ocationalsAcumulatedStart = Payments::select('created_at')
            ->where('payment_category', 'Ocasional')
            ->where('payment_status', 1)
            ->orderBy('created_at', 'asc')
            ->first();
        
        $ocationalsAcumulatedEnd = Payments::select('created_at')
            ->where('payment_category', 'Ocasional')
            ->where('payment_status', 1)
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->first();

        // dd($vpars, $vparf, $tars);
        return view('reports.index', compact('tyears', 'vpyears', 'tars', 'tarf', 'vpars', 'vparf', 'ocationalDailyYear', 'ocationalsAcumulatedStart', 'ocationalsAcumulatedEnd'));
    }

    public function generateReport(Request $request) {
        //dd($request);

        $tianguis = $request->tianguis;
        $semifijo = $request->semifijo;
        $ambulante = $request->ambulante;

        if ($tianguis == null && $semifijo == null && $ambulante == null) {
            
            $tianguis = 1;
            $semifijo = 2;
            $ambulante = 3;
        }

        // $from = $request->initialDate;
        // $to = $request->finalDate;

        $from = $request->initialDate . ' 00:00:00';
        $to = $request->finalDate . ' 23:59:59';
        
        $pagos = DB::table('payments')
            ->join('merchants', 'payments.merchant_id', 'merchants.merchant_id')
            ->join('locals', 'payments.local_id', 'locals.local_id')
            ->select('payments.*', 'merchants.nombre_comerciante', 
                'merchants.apellido_comerciante', 'merchants.giro', 'locals.ubicacion_reco', 'locals.dimx', 'locals.dimy')
            ->where('payments.payment_status', 1)
            ->where('payments.folio', '<>', 'null')
            ->whereBetween('payments.created_at', [$from, $to])
            ->where('merchants.category_id ', $tianguis)
            ->orWhere('merchants.category_id ', $semifijo)
            ->where('payments.payment_status', 1)
            ->where('payments.folio', '<>', 'null')
            ->whereBetween('payments.created_at', [$from, $to])
            ->orWhere('merchants.category_id ', $ambulante)
            ->where('payments.payment_status', 1)
            ->where('payments.folio', '<>', 'null')
            ->whereBetween('payments.created_at', [$from, $to])
            ->get();
        //dd($from, $to, $pagos);
        //return response()->json(($pagos), 200);
        return view('reportPDF_2023', compact('payments'));
    
    }

    public function showReport(Request $request)
    {
        //dd($request);
        $from = $request->initialDate;
        $to = $request->finalDate;
        $peticion = $request;
        $pagos = DB::table('payments')
            ->join('merchants', 'payments.merchant_id', 'merchants.merchant_id')
            ->join('locals', 'payments.local_id', 'locals.local_id')
            ->join('categorias', 'merchants.category_id ', 'categorias.category_id ')
            ->select('categorias.clase', DB::raw('SUM(payments.monto) as total'))
            ->where('payments.payment_status', 1)
            ->where('payments.folio', '!=', 'null')
            ->whereBetween('payments.created_at', [$from, $to])
            ->groupBy('categorias.clase')
            ->get();
        
        //dd($pagos);
        if ($pagos->count() >= 1) {
            
            //dd('entró al if');
            return redirect()->back()->with('error','No hay pagos en las fechas seleccionadas.');
        }
        else
        {
            //dd('entró al else');
            //$payments = Pago::all()->where('payment_status', 1);
            return view ('reportShowPDF', compact('payments', 'peticion'));
            
        }
    }

    public function dailyReport(Request $request)
    {
        // dd($request); 
        
        $fechaI = $request->year .'-' . $request->month . '-' . $request->day . ' 00:00:00';
        $fechaF = $request->year .'-' . $request->month . '-' . $request->day . ' 23:59:59';
        $cat = $request->cat;
        //dd($request, $fechaI, $fechaF, $cat);
        if ($cat == "tianguis") {
            $payments = Payments::select('payment_folio', 'payment_amount', 'payment_name', 'payment_activities', 'payment_dimentions', 
                    'payment_place', 'payment_category', 'payment_localVenue', 'payment_daysText', 'created_at', 'payment_startingDate',
                    'payment_endingDate')
                ->where('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Tianguista')
                ->get();
            $cat = 1;
            // dd($payments); 
            if ($request->buscarD == 1) {
                //dd('entró en buscar');
                return view('reports.lDailyReport', compact('payments', 'cat'));
            } else if ($request->descargarD == 2) {
                //dd('entró en descargar');
                return view('reports.excel.dailyTReport', compact('payments', 'cat'));
            }
        } elseif ($cat == "ocational") {
            $payments = Payments::where('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Ocasional')
                ->get();
            $cat = 4;
            // dd($payments, $cat); 
            if ($request->buscarD == 1) {
                //dd('entró en buscar');
                return view('reports.lDailyReport', compact('payments', 'cat'));
            } else if ($request->descargarD == 2) {
                //dd('entró en descargar');
                return view('reports.excel.dailyTReport', compact('payments', 'cat'));
            }
        }
        else {
            $payments = Payments::where('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Semifijo')
                ->orWhere('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Ambulante')
                ->get();
            $cat = 2;

            if ($request->buscarD == 1) {
                //dd('entró en buscar');
                return view('reports.lDailyReport', compact('payments', 'cat'));
            } else if ($request->descargarD == 2) {
                //dd('entró en descargar');
                return view('reports.excel.dailyVPReport', compact('payments', 'cat'));
            }
            //2023-01-25 14:21:25
        }
        
    }

    public function acumulatedReport(Request $request)
    {
        // dd($request);

        $fechaI = $request->IDatePayment . ' 00:00:00';
        $fechaF = $request->FDatePayment . ' 23:59:59';
        $cat = $request->cat;
        //dd($request, $fechaI, $fechaF, $cat);
        if ($cat == "tianguis") {
            //dd('if');
            // $payments = DB::table('merchants')
            //     ->join('payments', 'merchants.merchant_id', 'payments.merchant_id' )
            //     ->join('locals', 'payments.local_id', 'locals.local_id')
            //     ->join('categorias', 'merchants.category_id ', 'categorias.category_id ')
            //     ->join('tianguis', 'locals.tiangui_id', 'tianguis.tiangui_id')
            //     ->select('merchants.nombre_comerciante', 'merchants.apellido_comerciante', 
            //         'merchants.giro', 'payments.*', 'locals.dimx', 'locals.dimy', 'locals.ubicacion_reco', 
            //         'locals.local_lugares', 'categorias.clase', 'tianguis.nombre_tianguis', 
            //         'tianguis.tianguis_dia_letras')
            //     ->where('payments.payment_status', 1)
            //     ->where('payments.folio', '<>', 'null')
            //     ->whereBetween('payments.created_at', [$fechaI, $fechaF])
            //     ->where('merchants.category_id ', 1)
            //     ->get();
            $payments = Payments::select('payment_folio', 'payment_amount', 'payment_name', 'payment_activities', 'payment_dimentions', 
                    'payment_place', 'payment_category', 'payment_localVenue', 'payment_daysText', 'created_at', 'payment_startingDate',
                    'payment_endingDate')
                ->where('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Tianguista')
                ->get();
            $cat = 1;
            //2023-01-25 14:21:25
            if ($request->buscarD == 1) {
                //dd($payments);
                return view('reports.lDailyReport', compact('payments', 'cat'));
            } else if ($request->descargarD == 2) {
                //dd($payments);
                return view('reports.excel.dailyTReport', compact('payments', 'cat'));
            }
            
        } elseif ($cat == 'ocationals') {
            $payments = Payments::where('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Ocasional')
                ->get();
            $cat = 4;

            if ($request->buscarD == 1) {
                //dd('entró en buscar');
                return view('reports.lDailyReport', compact('payments', 'cat'));
            } else if ($request->descargarD == 2) {
                //dd('entró en descargar');
                return view('reports.excel.dailyVPReport', compact('payments', 'cat'));
            }
        } else {
            //dd('viapublica');
            // $payments = DB::table('merchants')
            //     ->join('payments', 'merchants.merchant_id', 'payments.merchant_id' )
            //     ->join('locals', 'payments.local_id', 'locals.local_id')
            //     ->join('categorias', 'merchants.category_id ', 'categorias.category_id ')
            //     ->select('merchants.nombre_comerciante', 'merchants.apellido_comerciante', 
            //         'merchants.giro', 'merchants.domicilio', 'merchants.comerciante_dias_letras', 
            //         'payments.*', 'locals.dimx', 'locals.dimy', 'locals.ubicacion_reco')
            //     ->where('payments.payment_status', 1)
            //     ->where('payments.folio', '<>', 'null')
            //     ->whereBetween('payments.created_at', [$fechaI, $fechaF])
            //     ->where('merchants.category_id ', 2)
            //     ->orWhere('merchants.category_id ', 3)
            //     ->whereBetween('payments.created_at', [$fechaI, $fechaF])
            //     ->where('payments.payment_status', 1)
            //     ->where('payments.folio', '<>', 'null')
            //     ->get();
            $payments = Payments::where('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Semifijo')
                ->orWhere('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Ambulante')
                ->orWhere('payment_status', 1)
                ->where('payment_folio', '<>', 'null')
                ->whereBetween('created_at', [$fechaI, $fechaF])
                ->where('payment_category', 'Ocasional')
                ->get();
            $cat = 2;

            if ($request->buscarD == 1) {
                //dd('entró en buscar');
                return view('reports.lDailyReport', compact('payments', 'cat'));
            } else if ($request->descargarD == 2) {
                //dd('entró en descargar');
                return view('reports.excel.dailyVPReport', compact('payments', 'cat'));
            }
            //2023-01-25 14:21:25
        }
    }

    public function excelDTReport(Request $request)
    {
        return view('reports.excel.dailyTReport');
    }

    
    public function ajaxTDRMonth(Request $request)
    {
        $year = $request->year;
        
        $payments = Payments::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, MONTHNAME(created_at) as month_name')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_category', 'Tianguista')
            ->having('year', $year)
            ->distinct('month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get();

            //$payments = $payments->groupBy('created_at')

        return response()->json(($payments), 200);
    }

    
    public function ajaxTDRDay(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        
        $payments = Payments::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_category', 'Tianguista')
            ->having('year', $year)
            ->having('month', $month)
            ->distinct('day')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'asc')
            ->get();

        return response()->json(($payments), 200);
    }

    public function ajaxVPDRMonth(Request $request)
    {
        $year = $request->year;
        
        $payments = Payments::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, MONTHNAME(created_at) as month_name')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_category', 'Ambulante')
            ->orWhere('payment_category', 'Semifijo')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->having('year', $year)
            ->distinct('month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json(($payments), 200);
    }

    public function ajaxVPDRDay(Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        $payments = Payments::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_category', 'Ambulante')
            ->orWhere('payment_category', 'Semifijo')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->having('year', $year)
            ->having('month', $month)
            ->distinct('day')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'asc')
            ->get();

        return response()->json(($payments), 200);
    }
    
    public function ajaxSearchMerchant($curp) {
        $merchant = Merchants::where('merchant_curp', 'LIKE', "%{$curp}%")->first();

        return response()->json(($merchant), 200);
    }

    public function ajaxGeneralReport($t, $s, $a, $o, $from, $to) {
        $from = $from . ' 00:00:00';
        $to = $to . ' 23:59:59';
        
        // $pagos = DB::table('pagos')
        //     ->join('comerciantes', 'pagos.id_comerciante', 'comerciantes.id_comerciante')
        //     ->join('locals', 'pagos.id_local', 'locals.id_local')
        //     ->join('categorias', 'comerciantes.id_categoria', 'categorias.id_categoria')
        //     ->join('tianguis', 'locals.id_tianguis', 'tianguis.id_tianguis')
        //     ->select('pagos.*', 'comerciantes.nombre_comerciante', 
        //         'comerciantes.apellido_comerciante', 
        //         'comerciantes.giro', 'locals.ubicacion_reco', 'locals.dimx', 'locals.dimy', 
        //         'categorias.clase', 'tianguis.nombre_tianguis', 'tianguis.tianguis_dia_letras')
        //     ->where('pagos.estatus_pago', 1)
        //     ->where('pagos.folio', '!=', 'null')
        //     ->whereBetween('pagos.created_at', [$from, $to])
        //     ->where('comerciantes.id_categoria', $tianguis)
        //     ->orWhere('comerciantes.id_categoria', $semifijo)
        //     ->where('pagos.estatus_pago', 1)
        //     ->where('pagos.folio', '!=', 'null')
        //     ->whereBetween('pagos.created_at', [$from, $to])
        //     ->orWhere('comerciantes.id_categoria', $ambulante)
        //     ->where('pagos.estatus_pago', 1)
        //     ->where('pagos.folio', '!=', 'null')
        //     ->whereBetween('pagos.created_at', [$from, $to])
        //     ->get();
        
        $pagos = Payments::where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_folio', '<>', null)
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_category', $t)
            ->orWhere('payment_status', 1)
            ->where('payment_folio', '<>','null')
            ->where('payment_folio', '<>', null)
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_category', $s)
            ->orWhere('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_folio', '<>', null)
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_category', $a)
            ->orWhere('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_folio', '<>', null)
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_category', $o)
            ->get();
        //dd($tianguis, $semifijo, $ambulante, $from, $to, $pagos );
        //return response()->json(($pagos), 200);
        return view('ajaxReportPDF_2023', compact('pagos'));
    }    

    public function ajaxQuickReport(Request $request) {
        $from = $request->from;
        $to = $request->to;
        $from = $from . ' 00:00:00';
        $to = $to . ' 23:59:59';
        // return response()->json(($to), 200);

        // $pagos = DB::table('pagos')
        //     ->join('comerciantes', 'pagos.id_comerciante', 'comerciantes.id_comerciante')
        //     ->join('locals', 'pagos.id_local', 'locals.id_local')
        //     ->join('categorias', 'comerciantes.id_categoria', 'categorias.id_categoria')
        //     ->select('categorias.clase', DB::raw('SUM(pagos.monto) as total'))
        //     ->where('pagos.estatus_pago', 1)
        //     ->where('pagos.folio', '!=', 'null')
        //     ->whereBetween('pagos.created_at', [$from, $to])
        //     ->groupBy('categorias.clase')
        //     ->get();

        $pagos = Payments::select('payment_category')
            ->selectRaw('SUM(payment_amount) as total')
            ->where('payment_status', 1)
            ->whereNotNull('payment_folio')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('payment_category')
            ->get();
            
        //dd($pagos);
        return response()->json(($pagos), 200);
        if ($pagos->count() >= 1) {
            return response()->json(($pagos), 200);
        } else {
            return response()->json(('error No hay pagos en las fechas seleccionadas.'), 200);
            
        }   
        // return response()->json(($request), 200);
    }

    public function ajaxOcationalMonthDailyReport(Request $request) {
        $year = $request->year;
        
        $payments = Payments::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, MONTHNAME(created_at) as month_name')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_category', 'Ocasional')
            ->having('year', $year)
            ->distinct('month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json(($payments), 200);
    }

    public function ajaxOcationalDayDailyReport(Request $request) {
        $year = $request->year;
        $month = $request->month;

        $payments = Payments::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day')
            ->where('payment_status', 1)
            ->where('payment_folio', '<>', 'null')
            ->where('payment_category', 'Ocasional')
            ->having('year', $year)
            ->having('month', $month)
            ->distinct('day')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'asc')
            ->get();

        return response()->json(($payments), 200);
    }





}
