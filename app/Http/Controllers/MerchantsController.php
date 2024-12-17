<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Locals;
use App\Models\Markets;
use App\Models\Merchants;
use App\Models\Payments;
use App\Models\Places;
use App\Models\Records;
use App\Models\Tianguis;
use App\Models\User;
use App\Models\Warnings;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class MerchantsController extends Controller
{
    public function index(){
        // $merchants = Merchants::all();
        // foreach ($merchants as $merchant) {
        //     $merchant->merchant_names = strtolower($merchant->merchant_names);
        //     $merchant->merchant_curp = strtolower($merchant->merchant_curp);
        //     $merchant->merchant_address = strtolower($merchant->merchant_address);
        //     $merchant->merchant_activity = strtolower($merchant->merchant_activity);
        //     $merchant->merchant_daysText = strtolower($merchant->merchant_daysText);
        //     $merchant->save();
        // }

        // $locals = Locals::all();
        // foreach ($locals as $local) {
        //     $local->local_location = strtolower($local->local_location);
        //     $local->save();
        // }

        // $payments = Payments::all();
        // foreach ($payments as $payment) {
        //     $payment->payment_daysText = strtolower($payment->payment_daysText);
        //     if ($payment->payment_daysText == 'miÉrcoles') {
        //         $payment->payment_daysText = 'miércoles';
        //     }
        //     if ($payment->payment_daysText == 'sÁbado') {
        //         $payment->payment_daysText = 'sábado';
        //     }

        //     $payment->save();
        // }
        // $tianguis = Tianguis::all();
        // foreach ($tianguis as $tiangui) {
        //     $tiangui->tiangui_name = strtolower($tiangui->tiangui_name);
        //     $tiangui->tiangui_dayText = strtolower($tiangui->tiangui_dayText);
        //     if ($tiangui->tiangui_dayText == 'miÉrcoles') {
        //         $tiangui->tiangui_dayText = 'miércoles';
        //     }
        //     if ($tiangui->tiangui_dayText == 'sÁbado') {
        //         $tiangui->tiangui_dayText = 'sábado';
        //     }
        //     $tiangui->save();
        // }

        // $users = User::all();
        // foreach ($users as $user) {
        //     $user->name = strtolower($user->name);
        //     $user->save();
        // }

        // $locals = Locals::all();
        // foreach ($locals as $local) {
        //     if ($local->local_places == 1) {
        //         $local->local_area = $local->local_dimx * $local->local_dimy;
        //     } else {
        //         $area = 0;
        //         foreach ($local->RLocalPlaces as $lugar) {
        //             $area += ($lugar->place_dimx * $lugar->place_dimy);
        //         }
        //         // if ($local->local_id == 547) {
        //         //     // dd($lugar->place_dimx + $lugar->place_dimy);
        //         //     dd($area);
        //         // }
        //         $local->local_area = $area;
        //     }
        //     $local->save();
        // }

        // $payments = Payments::all();
        // foreach ($payments as $payment) {
        //     if ($payment->RPaymentsLocals->local_places == 1) {
        //         $payment->payment_dimentions = "dimensiones = " . $payment->RPaymentsLocals->local_dimx . ' * ' . $payment->RPaymentsLocals->local_dimy; 
        //     } else {
        //         $payment->payment_dimentions = "dimensiones = ";
        //         foreach ($payment->RPaymentsLocals->RLocalPlaces as $lugar) {
        //             $payment->payment_dimentions .= ' ' . $lugar->place_dimx . ' * ' . $lugar->place_dimy;
        //         }
        //     }
        //     $payment->payment_dimentions .= ' m';
        //     $payment->save();
        // }

        // $payments = Payments::all();
        // foreach ($payments as $payment) {
        //     $payment->payment_area = $payment->RPaymentsLocals->local_area;
        //     $payment->save();
        // }

        // $locals = Locals::all();
        // foreach ($locals as $local) {
        //     $extra = 0;
        //     foreach ($local->RLocalPlaces as $lugar) {
        //         $extra += $lugar->place_extra;
        //     }
        //     $local->local_extraMeters = $extra;
        //     $local->save();
        // }

        // $payments = Payments::all();
        // foreach ($payments as $payment) {
        //     $payment->payment_extraMeters = $payment->RPaymentsLocals->local_extraMeters;
        //     $payment->save();
        // }


        return view('merchants.rComerciantes');
    }

    public function saveMerchant(Request $request)
    {
        // dd($request);
        $request->validate([
            'nombre' => ['required', 'string', 'min:2'],
            'merchant_curp' => ['string', 'min:18', 'max:18', 'unique:merchants'], 
            'direccion' => ['required', 'string', 'max:255'],
        ]);

        //dd($wdays);
        $merchant = new Merchants();

        $merchant->merchant_names = strtolower($request->nombre);
        $merchant->merchant_curp = strtolower($request->merchant_curp);
        $merchant->merchant_address = strtolower($request->direccion);
        if ($request->telefono1) {
            $merchant->merchant_phone1 = $request->telefono1;
        }
        if ($request->telefono2) {
            $merchant->merchant_phone2 = $request->telefono2;
        }
        if ($request->merchant_rfc) {
            $merchant->merchant_rfc = $request->merchant_rfc;
        }
        $merchant->id = Auth::user()->id; // quién lo registró
        // dd($request, $merchant);
        try {
            $merchant->save();
            //$catMerchant = Merchants::where('merchant_curp', $curp)->first();
            // dd($merchant);
            return redirect()->route('merchant.registerLocal', $merchant->merchant_curp)->with('success', 'Comerciante registrado correctamente');
            
        } catch (\Throwable $th) {
            //throw $th;
            $del = Merchants::where('merchant_curp',$merchant->merchant_curp)->delete();
            return redirect()->route('home', compact('th'))->with('error','El comerciante no ha sido registrado.');
        }
        
    }

    public function merchantList(Request $request){
        // dd($request);

        if ($request->seleccion == 1) {
            $curp = strtolower($request->curp);
            $merchants = Merchants::all()->where('merchant_curp', 'like', "%$curp%");
            // dd($request->curp, $curp, $merchants);
            return view('merchants.list', compact('merchants'));
        }
        if ($request->seleccion == 2) {
            $nombre = strtolower($request->name);
            $arrayNombre = explode(" ", $nombre);
            $count = count($arrayNombre);
            $list = array();
            $query = array();

            // Search for individual name parts
            for ($i = 0; $i < $count; $i++) {
                $query = Merchants::select('merchant_id')
                    ->where('merchant_names', 'LIKE', "%{$arrayNombre[$i]}%")
                    ->pluck('merchant_id');
                $list = array_merge($list, $query->toArray());
            }

            // Search for the full name
            $query2 = Merchants::select('merchant_id')
                ->where('merchant_names', 'LIKE', "%{$nombre}%")
                ->pluck('merchant_id');
            $list = array_merge($list, $query2->toArray());

            // Make the list unique to avoid duplicates
            $list = array_unique($list);

            // Fetch the merchants based on the unique list of IDs
            $merchants = Merchants::select('merchant_id', 'merchant_names', 'merchant_curp', 'merchant_address', 'merchant_phone1', 
                    'merchant_phone2', 'merchant_warnings', 'merchant_status')
                ->whereIn('merchant_id', $list)
                ->get();

            // dd($nombre, $list, $merchants);

            return view('merchants.list', compact('merchants'));
        }
        if ($request->seleccion == 3) { 
            
            $merchants = Merchants::all();

            return view('merchants.list', compact('merchants'));
        }
        
        //$locals = Locals::all();
        // dd($locals);||
        return view('home')->with('message', 'Error en la busqueda.');
    }

    public function registerNewLocal($curp) {

        $curp = strtolower($curp);
        $types = Category::all()->where('category_status', 1);
        $tianguis = Tianguis::all()->where('tiangui_status', 1)->where('tiangui_id', '<>', 1);
        $markets = Markets::all()->where('market_status', 1)->where('market_id', '<>', 1);
        
        // dd($markets);
        return view('merchants.rLocal', compact('curp', 'tianguis', 'types', 'markets'));
    }

    public function saveMerchantLocal($curp, Request $request){
        // dd($request, $curp); 
        // http://localhost:8000/registrarNuevoLocal/jitv930430hcsmmd05
        $flagy = true;
        $sumx = 0;
        $sumy = 0;
        $control = 0;
        $local = new Locals();
        for ($i=1; $i <= $request->lugares; $i++) { 
            
            if (request("dimx".$i) == 1 && $flagy) {
                $sumx = 1;
                $sumx = $sumx;
            } else {
                $sumx = $sumx + request("dimx".$i);
            }
            if (request("dimy".$i) == 1 && $flagy) {
                $sumy = 1;
                $sumy = $sumy;
            } else {
                $sumy = $sumy + request("dimy".$i); 
            }
            $sumx1 = request("dimx".$i);
            $sumy1 = request("dimy".$i);
            
            $val = request("dimx".$i)*request("dimy".$i);
            $control = $control + $val;
            
        }
        
        $business = "";
        $days = "";
        $days_l = "";
        $giros = $request->giro;
        $wdays = $request->dia;
        
        //dd($giros);
        if ($request->giro) {
            $contador = count($request->giro);
            for ($i=0; $i < $contador; $i++) { 
                $business = $business.strtolower($giros[$i]).',';
            }
        } else {
            $contador = 0;
        }
        
        if($request->otrosg != null)
        {
            $business = $business.strtolower($request->otrosg).',';
        }
        if ($request->categoria <> 1) {
            $contador = count($request->dia);
            for ($i=0; $i < $contador; $i++) { 
                
                $days = $days.strtolower($wdays[$i]).',';
                if ($wdays[$i] == 1) {
                    $days_l = $days_l . "lunes,";
                }
                if ($wdays[$i] == 2) {
                    $days_l = $days_l . "martes,";
                }
                if ($wdays[$i] == 3) {
                    $days_l = $days_l . "miércoles,";
                }
                if ($wdays[$i] == 4) {
                    $days_l = $days_l . "jueves,";
                }
                if ($wdays[$i] == 5) {
                    $days_l = $days_l . "viernes,";
                }
                if ($wdays[$i] == 6) {
                    $days_l = $days_l . "sábado,";
                }
                if ($wdays[$i] == 7) {
                    $days_l = $days_l . "domingo,";
                }
            }
            $local->local_days = $days;
            $local->local_daysText = $days_l;
        } 
        
        //dd($sumx, $sumy);
        $local->local_location = strtolower($request->ubicacion);
        $local->category_id = $request->categoria;
        $local->local_activity = strtolower($business);
        
        if ($request->categoria == 1 ) { // para tianguista 
            $tianguis = Tianguis::select('tiangui_day', 'tiangui_dayText', 'tiangui_startingHour', 'tiangui_endingHour')->where('tiangui_id', $request->tianguis)->where('tiangui_status', 1)->first();
            // dd($tianguis);  
            $local->local_places = $request->lugares;
            $local->tiangui_id = $request->tianguis;
            $local->market_id = 1;
            $local->local_startingHour = $tianguis->tiangui_startingHour;
            $local->local_endingHour = $tianguis->tiangui_endingHour;
            $local->local_dimx = $sumx1; 
            $local->local_dimy = $sumy1; 
            $local->local_area = $control;
            $local->local_days = $tianguis->tiangui_day;
            $local->local_daysText = $tianguis->tiangui_dayText;
            $local->regulation_id = 1;
            $local->category_id = $request->categoria;
            //dd($local);
        } elseif ($request->categoria == 4) { // para ocasionales
            $markets = Markets::select('market_startingHour', 'market_endingHour') 
                ->where('market_id', $request->OLugar)
                ->first();

            $extra = 0;
            for ($i=1; $i <= $request->oLugares; $i++) { 
                if (request("ODimx".$i) <> null ) {
                    $sumx += request("ODimx".$i) ;
                }
                if (request("ODimy".$i) <> null ) {
                    $sumy += request("ODimy".$i) ;
                } 
                if (request("extraMeters".$i) <> null ) {
                    $extra += request("extraMeters".$i) ;
                }     
                
                $control = $control + $sumx + $sumy;
                
            }
            if ($control == 0) {
                $sumx1 = request("ODimx".$i);
                $sumy1 = request("ODimy".$i);
                
                $val = request("ODimx".$i)*request("ODimy".$i);
                $control = $control + $val;
            }
            
            
            $local->tiangui_id = 1;
            $local->market_id = $request->OLugar;
            $local->local_startingHour = $markets->market_startingHour;
            $local->local_endingHour = $markets->market_endingHour;
            $local->local_places = $request->oLugares;
            $local->local_dimx = $sumx; 
            $local->local_dimy = $sumy; 
            $local->local_area = $control;
            $local->local_extraMeters = $extra;
            $local->category_id = $request->categoria;
            $local->regulation_id = 2;
            // dd($request, $local, $sumx, $sumy, $control);
        } elseif ($request->categoria == 2 || $request->categoria == 3) { // para todo lo que venga después XD 
            if($sumx ==  0 && $sumy == 0)
            {
                $sumx1 = $request->dimx;
                $sumy1 = $request->dimy;
            } 
            $local->local_area = $sumx1 * $sumy1;
            $local->local_dimx = $sumx1; 
            $local->local_dimy = $sumy1; 
            $local->tiangui_id = 1;
            $local->market_id = 1;
            $local->local_startingHour = $request->IHour;
            $local->local_endingHour = $request->FHour;
            $local->category_id = $request->categoria;
            $local->regulation_id = 1;
            // dd($request, $local);
            
        } else {
            return redirect()->back()->withError('Error fatal.')->withInput();
        }
        
        // dd($request, $local);
        try {
            $local->save();
            
            $registro = new Records();
            $merchant_id = Merchants::select('merchant_id')->where('merchant_curp', $curp)->where('merchant_status', 1)->first();
            $registro->merchant_id = $merchant_id->merchant_id;
            $registro->local_id = $local->local_id;
            // $registro->local_id = 557;
            // dd($registro, $merchant_id);
            $registro->save();
            if ($request->lugares > 1) {
                for ($i=1; $i <= $request->lugares; $i++) { //los lugares solo se manejan para los tianguistas y ocasionales, por 
                    // los números internos y eso, a los demás, solo con las medidas del local salen las cuentas
                    // si en algún momento hay otro tipo de categoría que maneje multiples lugares que no sea
                    // el ocasional, sería moverle aquí 
                    $lugar = new Places();
                    $lugar->place_dimx = request("dimx".$i);
                    $lugar->place_dimy = request("dimy".$i);
                    $lugar->place_extra = 0;
                    
                    $lugar->local_id = $local->local_id;
                    // $lugar->local_id = 557;
                    //dd($request, $request->local_dimx.$i, $request->local_dimy.'2', $lugar);
                    $lugar->save();
                }
            } 
            if ($request->oLugares > 1) {
                for ($i=1; $i <= $request->oLugares; $i++) { 
                    $lugar = new Places();
                    $lugar->place_dimx = request("ODimx".$i);
                    $lugar->place_dimy = request("ODimy".$i);
                    $lugar->place_extra = request("extraMeters".$i);
                    $lugar->local_id = $local->local_id;
                    // $lugar->local_id = 557;
                    $lugar->save();
                }
            }
            
            // dd($curp, $request, $local, $lugar, $registro, $record);
            if ($request->categoria == 4) {
                // return redirect()->route('payment.new', [$curp, $registro->record_id])
                return redirect()->route('payment.new', [$curp, 556])
                    ->with('success', 'El local del comerciante se ha agregado correctamente.');
            } else {
                return redirect()->route('payment.new', [$curp, $registro->record_id])
                    ->with('success', 'El local del comerciante se ha agregado correctamente.');
            }
            
            
            
        } catch (ModelNotFoundException $exception) {
            //throw $th;
            $delLocal = Locals::select('local_id')->orderBy('local_id','desc')->first();
            //dd($delLocal);
            $delocal = Locals::where('local_id', $delLocal)->delete();
            $delRegis = Records::orderBy('local_id','desc')->first();
            $delRegi = Records::where('local_id', $delRegis)->delete();
            return redirect()->back()->withError($exception->getMessage())->withInput();
        }
    }
    
    public function downloadQR($merchant_id ){
        $merchant = Merchants::where('merchant_id ', $merchant_id )->first();
        
        //dd($merchant_id , $merchant);
        return view ('qr', compact('merchant'));
        }

    public function inspectMerchant($curp) {
        $merchant = Merchants::where('merchant_curp', $curp)->first(); 
        // dd($merchant, $curp);
        if ($merchant) {
            if ($merchant->merchant_status == 1) {
                $idM = $merchant->merchant_id ;
                $locales = DB::table('merchants')
                    ->join('records', 'merchants.merchant_id', 'records.merchant_id')
                    ->join('locals', 'records.local_id', 'locals.local_id')
                    ->leftJoin('tianguis', 'locals.tiangui_id', 'tianguis.tiangui_id')
                    ->leftJoin('markets', 'locals.market_id', 'markets.market_id')
                    ->select('merchants.*', 'locals.*', 'tianguis.*', 'markets.*')
                    ->where('record_status', 1)
                    ->where('merchant_curp', $curp)
                    ->get();
                
                //$pago = Pago::where('merchant_id ', $idM)->where('local_id', $local_id)->first();
                // dd($curp, $idM, $merchant, $locales);
                return view('merchants.iComerciante', ['merchant_curp' => $curp], compact('merchant', 'locales'));
            } else {
                return view('home')->with('error', 'comerciante dado de baja');
            }
        } else {
            return view('home')->with('error', 'comerciante no encontrado');
        }
    }

    public function howMerchant() {
        return view('merchants.howComerciantes');
    }

    public function inspectMerchantTwo($curp) {
        //dd($curp, $id);
        $merchant = Merchants::where('merchant_curp', $curp)->first(); 
        $idM = $merchant->merchant_id ;
        
        $locales = DB::table('merchants')
            ->join('registros', 'comerciantes.merchant_id ', '=', 'registros.merchant_id ')
            ->join('locals', 'registros.local_id', '=', 'locals.local_id')
            ->leftJoin('tianguis', 'tianguis.tiangui_id', '=', 'locals.tiangui_id')
            ->select('comerciantes.*', 'locals.*', 'tianguis.*')
            ->where('estatus_registro', 1)
            ->where('comerciantes.curp', $curp)
            ->get();

            /* $locales = DB::table('merchants')
            ->join('registros', 'comerciantes.merchant_id ', '=', 'registros.merchant_id ')
            ->join('locals', 'registros.local_id', '=', 'locals.local_id')
            ->join('pagos', 'locals.local_id', '=', 'pagos.local_id')
            ->leftJoin('tianguis', 'tianguis.tiangui_id', '=', 'locals.tiangui_id')
            ->select('comerciantes.*', 'locals.*', 'tianguis.*', 'pagos.*')
            ->where('estatus_registro', 1)
            ->where('comerciantes.curp', $curp)
            ->where('payment_status', 1)
            ->get(); */

        //dd($locales);
        //$pago = Pago::where('merchant_id ', $idM)->where('local_id', $local_id)->first();
        //dd($curp, $idM, $local_id, $merchant, $locales, $idM, $pago);
        return view('merchants.iComercianteDos', ['merchant_curp' => $curp], compact('merchant', 'locales'));
    }

    public function cancelMerchant ($id) {
        //dd($id);
        $merchant = Merchants::where('merchant_curp', $id)->first();
        $X = 'XXX';
        $merchant->merchant_status = 2;
        $merchant->merchant_curp = $merchant->merchant_curp.$X;
        $merchant->save();
        $merchants = Merchants::where('merchant_status', 2)->get();

        /*foreach ($merchants as $merchant) {
            
            $merchant->dias = str_replace("1","LUNES", $merchant->dias);
            $merchant->dias = str_replace("2","MARTES", $merchant->dias);
            $merchant->dias = str_replace("3","MIÉRCOLES", $merchant->dias);
            $merchant->dias = str_replace("4","JUEVES", $merchant->dias);
            $merchant->dias = str_replace("5","VIERNES", $merchant->dias);
            $merchant->dias = str_replace("6","SÁBADO", $merchant->dias);
            $merchant->dias = str_replace("7","DOMINGO", $merchant->dias);
            $merchant->dias = substr($merchant->dias, 0, -1);
        }*/

        return view('merchants.uComerciantes', compact('merchants'));
    }

    public function listDownMerchants()
    {
        $merchants = Merchants::where('merchant_status', 2)->get();

        return view('merchants.uComerciantes', compact('merchants'));
    }

    public function returningMerchant($id) {
        // dd($id);
        $merchant = Merchants::where('merchant_curp', $id)->first();
        
        if($merchant->merchant_warnings >= 2)
        {
            $apercibimientos = Warnings::all()->where('warning_status', 1);
            
            return redirect()->route('warnings.especificList', ['id' => $id])->with(compact('apercibimientos'))->with('error', 'El comerciante tiene apercibimientos por enmendar.');
        }
        //dd($id, $merchant);
        $merchant_id = $merchant->merchant_id;
        $affected = Merchants::find($merchant_id);
        $affected->merchant_status = 1;
        $affected->save();
        
        $merchants = Merchants::where('merchant_status', 1)->get();
        
        return view('merchants.howComerciantes', compact('merchants'))->with('success', 'El comerciante ha sido reincorporado correctamente.');
        //return view('merchants.list', compact('merchants'))->with('success', 'El comerciante ha sido reincorporado correctamente.');
    }

    public function updateMerchant(Request $request)
    {
    	// dd($request);
        $requestData = $request->all();

        // Rename the 'folio' field to 'payment_folio' in the request data
        $requestData['merchant_names'] = $requestData['nombre'];
        $requestData['merchant_curp'] = $requestData['curp'];
        $requestData['merchant_address'] = $requestData['direccion'];
        unset($requestData['nombre']); // Remove the 'folio' field
        unset($requestData['curp']);
        unset($requestData['direccion']);
		// dd($requestData);
        $modifiedRequest = new Request($requestData);
		// dd($modifiedRequest);
        // Validate the modified request        
        $modifiedRequest->validate([
            'merchant_names' => ['required', 'string', 'min:2'],
            'merchant_curp' => ['string', 'min:18', 'max:18'], 
            'merchant_address' => ['required', 'string', 'max:255'],
        ]);

        // dd($request);
        $merchant = Merchants::where('merchant_curp', $request->curp)->first();

        $merchant->merchant_names = strtolower($request->nombre);
        $merchant->merchant_curp = strtolower($request->curp);
        $merchant->merchant_address = strtolower($request->direccion);
        if ($request->telefono1 != null) {
            $merchant->merchant_phone1 = strtolower($request->telefono1);
        }
        if ($request->telefono2 != null) {
            $merchant->merchant_phone2 = strtolower($request->telefono2);
        }
        if ($request->merchant_rfc) {
            $merchant->merchant_rfc = $request->merchant_rfc;
        }
        $merchant->id = Auth::user()->id;
        // dd($merchant);
        try {
            $merchant->save();
            
            return redirect()->route('home')->with('success','El comerciante se ha actualizado correctamente.');
            //return view('merchants.list', compact('merchants', 'types'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('home')->with('error','El comerciante no se ha actualizado correctamente.');
        }
    }
}
