<?php

namespace App\Http\Controllers;

use App\Models\Amounts;
use App\Models\Category;
use App\Models\Locals;
use App\Models\Markets;
use App\Models\Merchants;
use App\Models\Payments;
use App\Models\Places;
use App\Models\Records;
use App\Models\Tianguis;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);

        $index = $request->categories;
        if ($request->seleccion == 1) {
            $curp = strtolower($request->curp);
            $payments = Payments::where('payment_status', 1)
                ->where('merchant_curp', $curp)
                ->orderBy('payment_endingDate', 'asc')
                ->get();
            //$merchants = Merchants::all()->where('merchant_status', 1);

            return view('payments.lPayments', compact('payments'));
        }
        if ($request->seleccion == 2) {
            // dd($request);
            // $var = [];
            // $h = 0;
            // $categories = Category::select('category_id', 'category_type')->where('category_status', 1)->get();
            // foreach ($categories as $category) {
            //     $var[$h] = substr($category->category_type, 0, 1);
            // }
            // $tianguis = $request->T;
            // $semifijo = $request->S;
            // $ambulante = $request->A;

            // if ($tianguis == 0 && $semifijo == 0 && $ambulante == 0) {
            //     $payments = Payments::all()->where('payment_status', 1);
            //     //dd($payments);
            //     if ($payments != null) {
            //         return view('payments.lPayments', compact('payments'));
            //     }
            // }

            if (empty($request->categories)) {
                // dd('entró');
                return redirect()->back()->with('error', 'Ningún campo seleccionado.');
            }

            // $payments = DB::table('comerciantes')
            //     ->join('pagos', 'comerciantes.merchant_id ', 'pagos.merchant_id ')
            //     ->join('locals', 'pagos.local_id', 'locals.local_id')   
            //     ->join('categorias', 'locals.category_id ', 'categorias.category_id ')
            //     ->select('comerciantes.*', 'pagos.*', 'locals.*', 'categorias.clase')
            //     ->where('payment_status', 1)
            //     ->where('locals.category_id ', $tianguis)
            //     ->orWhere('locals.category_id ', $semifijo)
            //     ->where('payment_status', 1)
            //     ->orWhere('locals.category_id ', $ambulante)
            //     ->where('payment_status', 1)
            //     ->get();

            // $locals = Locals::with(['RLocalPayments' => function ($query) {
            //         $query->whereNotNull('payment_folio')->orWhere('payment_folio', '<>', '')->orWhere('payment_folio', '<>', ' ')->orWhere('payment_folio', '<>', '  ');
            //     }])->whereIn('category_id', $request->categories)
            //     ->where('local_status', 1)
            //     ->limit(2)
            //     ->get();
            // dd($index);

            $index = $request->categories;
            // $payments = Payments::with(['RPaymentsLocals' => function($query) use ($index) {
            //     // $query->where('local_status', 1)->whereIn('category_id', $index)->whereNot('local_status', 2);
            //     $query->whereIn('category_id', $index)->where('local_status', 1);
            // }])->whereNotNull('payment_folio')
            //     ->where('payment_status', 1)
            //     // ->orWhere('payment_folio', '<>', '')
            //     // ->orWhere('payment_folio', '<>', ' ')
            //     // ->orWhere('payment_folio', '<>', '  ')
            //     ->where('payment_name', 'maria luisa pizano gonzalez')
            //     // ->limit(2)
            //     ->get();
            
            $payments = Payments::where('payment_status', 1)
                ->whereNotNull('payment_folio')
                // ->where('payment_name', 'maria luisa pizano gonzalez')
                ->whereHas('RPaymentsLocals', function($query) use ($index) {
                    $query->whereIn('category_id', $index)
                        ->where('local_status', 1);
                })
                ->orderBy('payment_endingDate', 'desc')
                ->get();
            // $locals = Locals::whereIn('category_id', $request->categories)
            // ->where('local_status', 1)
            // ->limit(10)
            // ->get();
            // dd($payments);
            
            return view('payments.listCatPayments', compact('payments'));
        } elseif ($request->seleccion == 3) {
            $payments = Payments::where('payment_status', 1)
                ->orderBy('payment_endingDate', 'desc')
                ->get();
            //dd($payments);
            if ($payments != null) {
                return view('payments.lPayments', compact('payments'));
            }

            return redirect()->route('home')->with('error', 'Surgió un problema.');
        } elseif ($request->seleccion == 4) {
            // dd($request);
            $name = strtolower($request->name);
            // $payments = Payments::all()->where('payment_name', 'like', '%'.$name.'%')->where('payment_status', 2);
            $payments = Payments::where('payment_name', 'like', "%{$name}%")
                ->where('payment_status', 1)
                ->orderBy('payment_endingDate', 'desc')
                ->get();
            // dd($request, $name, $payments);
            if (!$payments->isEmpty()) {
                return view('payments.lPayments', compact('payments'));
            } else {
                return redirect()->back()->with('error', 'El comerciante no tiene pagos asociados.');
            }

        }
    }

    public function howShowPayments()
    {
        $categories = Category::select('category_id', 'category_type')->where('category_status', 1)->get();
        
        // $categoryArray = [];

        // return view('payments.howPayments', compact('categories', 'categoryArray'));
        return view('payments.howPayments', compact('categories'));
    }

    public function newPayment($curp, $registro)
    {
        // dd($curp, $registro);
        $merchant = Merchants::all()->where('merchant_curp', $curp)->where('merchant_status', 1)->first();
        $record = Records::find($registro);
        // dd($merchant, $record);
        $local = Locals::find($record->local_id);

        // dd($merchant, $record, $local, $registro);
        if ($local->category_id == 1) {     // para tianguistas
            $montos = Amounts::all()->where('amount_status', 1)->where('regulation_id', 1);
            $tianguis = Tianguis::find($local->tiangui_id);
            // $pagos = Payments::where('local_id', $record->local_id)->latest()->first(); 
            // los pagos se quitan ya que no se usan como fecha inicial forzosa, en un momento se pensó que sí
            // dd($local);
            if ($local->local_places > 1) {
                $lugares = Places::where('local_id', $local->local_id)->where('place_status', 1)->get();
            } else {
                $lugares = 1;
            }
            return view('payments/nPayment', [$curp, $record->record_id])
                ->with(compact('merchant', 'record', 'local', 'montos', 'tianguis', 'lugares'));
        } elseif ($local->category_id  == 4) {      // para ocasionales
            $market = Markets::find($local->market_id);
            $montos = Amounts::all()->where('amount_status', 1)->where('regulation_id', 2);
            $extras = Amounts::where('amount_status', 1)->where('regulation_id', 3)->get();

            $lugares = Places::all()->where('local_id', $local->local_id)->where('place_status', 1);
            $totalExtra = 0;
            foreach ($lugares as $lugar) {
                $totalExtra += $lugar->place_extra;
            }
            // $totalExtra = 0;
            // dd($market, $montos, $extras);
            return view('payments/nPaymentOcationals', [$curp, $record->record_id])
                ->with(compact('merchant', 'record', 'local', 'montos', 'market', 'lugares', 'extras', 'totalExtra'));
        } else {
            // $pagos = Payments::where('local_id', $record->local_id)->orderBy('payment_id', 'desc')->first(); 
            // los pagos se quitan ya que no se usan como fecha inicial forzosa, en un momento se pensó que sí
            $montos = Amounts::all()->where('amount_status', 1)->where('regulation_id', 1);
            if ($local->local_places > 1) {
                $lugares = Places::where('local_id', $local->local_id)->get();
            } else {
                $lugares = 1;
            }
            return view('payments/nPaymentO', [$curp, $record->record_id])
                ->with(compact('merchant', 'record', 'local', 'montos', 'lugares'));
        }
    }

    public function savePayment(Request $request)
    {
        // dd('apenas voy a mpezar con los guardados de los pagos', $request);
        if ($request->dWorked == 0) { // aquí pregunto si no es 0 los días trabajados por lo tanto 0 el total a cobrar y regreso un error especial
            $curp = Merchants::select('merchant_curp')->where('merchant_id ', $request->merchant_id)->first();
            return redirect()->route('payment.locals', ['merchant_curp' => $curp->curp])->with('message', 'Error la cantidad de días laborales es 0');
            //no pude mandar el toast normal, no sé por qué, así que mandé un message adornado especial en la vista
        }
        $merchant = Merchants::all()->where('merchant_curp', $request->curp)->where('merchant_status', 1)->first();
        $pago = new Payments();
        if ($request->payment_folio != null) {
            $pago->payment_folio = $request->payment_folio;
        } else {
            $pago->payment_folio = null;
        }

        $pago->payment_startingDate = $request->IDatePayment;
        $pago->payment_endingDate = $request->FDatePayment;
        $pago->payment_amount = $request->total;
        $pago->payment_daysWorked = $request->daysPayed;
        $pago->payment_daysText = $request->dWorked;
        $pago->merchant_id  = $request->merchant_id;
        $pago->local_id = $request->local_id;
        $pago->payment_localVenue = $request->localVenue;

        try {
            //dd($pago);
            $pago->save();

            $payments = Payments::where('payment_status', 2)->orderBy('payment_id', 'desc')->get();
            //$merchants = Merchants::all()->where('merchant_status', 1);
            //dd($payments);
            return redirect()->route('payments.pending', compact('payments'))->with('success', 'El pago del comerciante se ha agregado correctamente.');
            //return redirect()->route('home')->with('message', 'El pago del comerciante se ha agregado correctamente.');

        } catch (ModelNotFoundException $exception) {
            //throw $th;
            $delPago = Payments::select('payment_id')->orderBy('payment_id', 'desc')->first();
            $delPago = Payments::where('payment_id', $delPago)->delete();

            return redirect()->back()->withErrors($exception->getMessage())->withInput();
        }
    }

    public function localsPayment($curp)
    {

        $merchant = Merchants::where('merchant_curp', $curp)->first();
        $registro = Records::where('merchant_id', $merchant->merchant_id)->get();
        if ($registro->count() >= 1) {

            $montos = Amounts::all()->where('amount_status', 1);
            // dd($montos);
            // return view('payments.dPayments',  ['merchant_curp' => $curp])->with(compact('merchant', 'locales', 'montos', 'lPayments'));
            return view('payments.merchantLocals',  ['merchant_curp' => $curp])->with(compact('merchant', 'montos'));
        } else {
            //dd($locales, 'asdds');
            return redirect()->route('merchant.registerLocal',  ['merchant_curp' => $curp])->with('error', 'El comerciante no tiene locales.');
        }
    }

    public function pendingPayments()
    {
        $payments = Payments::all()->where('payment_status', 2);
        //$merchants = Merchants::all()->where('merchant_status', 1);
        // dd($payments);
        return view('payments.listPendingPayments', compact('payments'));
    }

    public function downloadPDF($id)
    {

        $pago = Payments::where('payment_id', $id)->first();
        //dd($pago);
        // $lugares = Places::where('local_id', $pago->local_id)->where('place_status', 1)->get();
        // $dimx = 0;
        // $dimy = 0;
        // $area = 0;
        // foreach ($lugares as $lugar) {
        //     $dimx = $dimx + $lugar->lugar_dimx;
        //     $dimy = $dimy + $lugar->lugar_dimy;
        //     $area = $area + ($lugar->lugar_dimx * $lugar->lugar_dimy);
        // }
        // if ($dimx == 0 || $dimy == 0) {
        //     $local = Locals::find($pago->local_id);

        //     $dimx = $local->dimx;
        //     $dimy = $local->dimy;
        //     $area = $local->dimx * $local->dimxy;
        // }
        // //dd($pago);
        // $monto = round(($pago->monto / $pago->dias_laborales) / ($area), 2);

        // dd($pago, $lugares, $dimx, ($pago->payment_amount / $pago->dias_laborales), $dimy, $monto);
        //$pdf = PDF::loadView('pdf_2023', compact('pago', 'monto'));

        // return view('pdf_2023', compact('pago', 'monto', 'lugares'));
        return view('pdf_2023', compact('pago'));
        //return $pdf->download('pdf.pdf'); 

    }

    public function saveFolioPayments(Request $request)
    {
        // dd($request);
        $requestData = $request->all();

        // Rename the 'folio' field to 'payment_folio' in the request data
        $requestData['payment_folio'] = $requestData['folio'];
        unset($requestData['folio']); // Remove the 'folio' field

        $modifiedRequest = new Request($requestData);

        // Validate the modified request
        $modifiedRequest->validate([
            'payment_folio' => ['required', 'string', 'min:6', 'max:10', 'unique:payments'],
            // other validation rules...
        ]);
        
        $folio = strtolower($request->folio);
        $id = $request->payment_id;

        try {
            $pago = Payments::find($id);
            $pago->payment_folio = $modifiedRequest->payment_folio;
            $pago->payment_status = 1;
            $pago->save();

            //$catMerchant = Merchants::where('merchant_curp', $curp)->first();
            //dd($catMerchant);
            return redirect()->route('home')->with('success', 'El pago se ha actualizado correctamente');
        } catch (\Throwable $th) {
            //throw $th;
            $del = Payments::where('payment_id', $id)->delete();
            return redirect()->route('home')->with('error', 'El pago no se ha actualizado correctamente.', compact('th'));
        }
    }
    
    public function cancelPayment($id)
    {
        //dd($id); 
        try {

            $pago = Payments::find($id);
            $pago->payment_status = 3;
            $pago->save();

            $payments = Payments::all()->where('payment_status', 2);
            return redirect()->route('payments.pending', compact('payments'))->with('success', 'El pago se ha cancelado.');
        } catch (\Throwable $th) {
            //throw $th;
            $payments = Payments::all()->where('payment_status', 2);
            return redirect()->route('payments.pending', compact('payments'))->with('error', 'El pago no se ha cancelado.');
        }
    }

    public function downloadPayment($id)
    {
        // dd($id);
        $pago = Payments::where('payment_id', $id)->first();
        $lugares = Places::where('local_id', $pago->local_id)->where('place_status', 1)->get();
        // dd($pago, $lugares);
        // $dimx = 0;
        // $dimy = 0;
        // $area = 0;
        // foreach ($lugares as $lugar) {
        //     $dimx += $lugar->lugar_dimx;
        //     $dimy += $lugar->lugar_dimy;
        //     $area += $lugar->lugar_dimx * $lugar->lugar_dimy;
        // }
        // $local = Locals::find($pago->local_id);
        // if ($dimx == 0 || $dimy == 0) {
        //     $dimx = $local->local_dimx;
        //     $dimy = $local->local_dimy;
        //     $area = $local->local_dimx * $local->local_dimy;
        // } else {
        //     $area = $local->local_area;
        // }
        // dd($local);
        // $monto = round(($pago->monto / $pago->dias_laborales) / ($area), 2);

        // $monto = Amounts::orderBy('id_montos', 'desc')->where('estatus_monto', 1)->first();
        //dd($pago, $dimx, $dimy, $monto, $lugares);
        return view('pdf_2023', compact('pago'));
        // return view('pdf_2023', compact('pago', 'monto', 'lugares'));
    }

    public function saveOcasionalPayment(Request $request)
    {
        dd($request);
    }

    public function ajaxSavePayment(Request $request)
    {
        if ($request->dWorked == 0) { // aquí pregunto si no es 0 los días trabajados por lo tanto 0 el total a cobrar y regreso un error especial
            //$curp = Comerciante::select('curp')->where('id_comerciante', $request->id_comerciante)->first();
            return response()->json(('la cantidad de días es 0'), 200);
        }
        //$merchant = Comerciante::all()->where('curp', $request->curp)->where('estatus_comerciante', 1)->first();
        // dd($request);
        $local = Locals::find($request->local_id);
        $pago = new Payments();
        $pago->payment_name = $request->name;
        $pago->payment_startingDate = $request->IDatePayment;
        $pago->payment_endingDate = $request->FDatePayment;
        $pago->payment_startingHour = $local->local_startingHour;
        $pago->payment_endingHour = $local->local_endingHour;
        $pago->payment_amount = $request->total;
        $pago->payment_tarifAdjustment = $request->tarifAdjustment;
        $pago->payment_fiscalAmount = $request->fiscalAmount;
        $pago->payment_area = $request->area;
        if ($request->extraMeters) {
            $pago->payment_extraMeters = $request->extraMeters;
        }
        if ($request->extraMeterAmount) {
            $pago->payment_fiscalAmountExtraMeters = $request->extraMeterAmount;
        }
        $pago->payment_daysText = $request->daysT;
        $pago->payment_daysWorked = $request->dWorked;
        $pago->payment_place = $request->ubication;
        $pago->payment_dimentions = "dimensiones = " . $request->measurements;
        $pago->payment_activities = $request->activities;
        $pago->payment_category = $request->category;
        $pago->merchant_id = $request->merchant_id;
        $pago->local_id = $request->local_id;
        $pago->payment_localVenue = $request->localVenue;
        $montoFiscal = Amounts::select('amount_id')->where('amount_cost', $request->fiscalAmount)->first(); 
        $pago->amount_id  = $montoFiscal->amount_id;     // esta lq tengo que sacar a mano ya que envío el monto, no el id XD
                        // esto se envía ya que en la vista que hago los calculos uso el monto, y desconozco cómo en un mismo
                        // select pueda seleccionar el id y el valor para enviar el id y que esto sea más rápido
        // return response()->json(($pago), 200);
        try {
            $pago->save();
            
            // $payment = Payments::where('payment_status', 2)->orderBy('payment_id', 'desc')->first();
            return response()->json(($pago), 200);
        } catch (ModelNotFoundException $exception) {
            //throw $th;
            $delPago = Payments::select('payment_id')->orderBy('payment_id', 'desc')->first();
            $delPago = Payments::where('payment_id', $delPago)->delete();

            return redirect()->back()->withErrors($exception->getMessage())->withInput();
        }
    }

    public function editFolioPayment(Request $request) {
        // dd($request);
        $requestData = $request->all();

        // Rename the 'folio' field to 'payment_folio' in the request data
        $requestData['payment_folio'] = $requestData['folio'];
        unset($requestData['folio']); // Remove the 'folio' field

        $modifiedRequest = new Request($requestData);

        // Validate the modified request
        $modifiedRequest->validate([
            'payment_folio' => ['required', 'string', 'min:6', 'max:10', 'unique:payments'],
            // other validation rules...
        ]);
        
        $folio = strtolower($request->folio);
        $id = $request->id;

        try {
            $pago = Payments::find($id);
            $pago->payment_folio = $modifiedRequest->payment_folio;
            $pago->payment_status = 1;
            // dd($request, $pago);
            $pago->save();

            //$catMerchant = Merchants::where('merchant_curp', $curp)->first();
            //dd($catMerchant);
            return redirect()->route('home')->with('success', 'El pago se ha actualizado correctamente');
        } catch (\Throwable $th) {
            //throw $th;
            $del = Payments::where('payment_id', $id)->delete();
            return redirect()->route('home')->with('error', 'El pago no se ha actualizado correctamente.', compact('th'));
        }
    }

    public function APIindex() {
        $payments = Payments::select('payment_id', 'payment_name', 'payment_amount', 
            'payment_startingDate', 'payment_endingDate', 
            'payment_place', 'payment_localVenue', 
            'payment_daysWorked', 'payment_fiscalAmount', 'payment_dimentions', 'payment_activities')
            ->where('payment_status', 2)
            ->get();
        
        $payments->each(function ($item) {
            $item->payment_activities = trim($item->payment_activities, ',');
        });
        return $payments; 
    }

    public function APIcompletePayment(Request $request) {
        dd($request);
        $request->validate([
            'payment_id' => 'required|integer',
            'payment_folio' => 'required|string'
        ]);
        $payment = Payments::find($request->payment_id);
        if (!$payment) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }
        $payment->payment_folio = $request->payment_folio;
        try {
            $payment->save();
            return response()->json(['message' => 'Pago actualizado correctamente :D']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
