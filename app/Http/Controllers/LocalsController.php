<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Locals;
use App\Models\Markets;
use App\Models\Merchants;
use App\Models\Places;
use App\Models\Records;
use App\Models\Tianguis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocalsController extends Controller
{
    public function index() {
        //$locales = Local::all()->where('local_status', 1);
        
        $locales = DB::table('comerciantes')
        ->join('registros', 'comerciantes.merchant_id ', '=', 'registros.merchant_id ')
        ->join('locals', 'registros.local_id', '=', 'locals.local_id')
        ->leftJoin('tianguis', 'tianguis.tiangui_id', '=', 'locals.tiangui_id')
        ->select('comerciantes.*', 'locals.*', 'tianguis.*')
        ->where('estatus_registro', 1)
        ->get();
        $types = Category::all();
        //dd($locales);
        return view('locales.lLocales', compact('locales', 'types'));
    }

    public function nuevoLocalT(){
        $types = Category::all();
        $tianguis = Tianguis::all()->where('tiangui_status', 1);
        return view('locales.nLocalT', compact('tianguis', 'types'));
    }

    public function nuevoLocalA(){
        $types = Category::all();
        $tianguis = Tianguis::all()->where('tiangui_status', 1);

        return view('locales.nLocalA', compact('tianguis', 'types'));
    }

    public function saveLocal(Request $request, $curp) {
        //dd($request, $curp);
        
        $nlocal = new Locals();
        $nlocal->dimx = $request->dimx;
        $nlocal->dimy = $request->dimy;
        $nlocal->ubicacion_reco = $request->ubicacion;
        if ($request->cat == 1) {
            
            $tianguis = Tianguis::where('tiangui_id', $request->tianguis)->first();
            $nlocal->hora_inicio = $tianguis->thora_inicio; 
            $nlocal->hora_final = $tianguis->thora_final;
            $nlocal->tiangui_id = $tianguis->tiangui_id;
            //dd($local);
        }
        if ($request->cat == 2 || $request->cat == 3)
        {
            $nlocal->hora_inicio = $request->IHour; 
            $nlocal->hora_final = $request->FHour; 
        }
        
        //dd($local);
        try {
            
            $nlocal->save();
            //dd($nlocal);
            return redirect()->route('home')->with('success', 'El local del comerciante se ha agregado correctamente.');

        } catch (\Throwable $th) {
            //throw $th;
            return view('home')->with('error','El local del comerciante no se ha sido registrado.', compact('th'));
        }
    }

    public function updateLocal(Request $request)
    {
        
        //dd($request);
        $merchant = Merchants::find($request->merchant_id );
        $local = Locals::find($request->local_id);

        $local->dimx = $request->dimx;
        $local->dimy = $request->dimy;
        $local->local_location = $request->location;
        if ($local->category_id  != 1) {
            
            $local->local_startingHour = $request->IHour;
            $local->local_endingHour = $request->FHour;
        }

        try {
            
            $local->save();
            return redirect()->route('payment.locals', ['merchant_curp' => $merchant->curp])->with('success', 'El local del comerciante se ha actualizado correctamente.');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('payment.locals', ['merchant_curp' => $merchant->curp])->with('error','El local del comerciante no se ha actualizado.', compact('th'));
        }
        
    }

    public function cancelLocal($local_id)
    {
        
        //dd($local_id);
        $registro = Records::where('local_id', $local_id)->first();
        $merchant = Merchants::find($registro->merchant_id );
        $registro->record_status = 2;

        try {
            
            $registro->save();

            $lugares = Places::where('local_id', $registro->local_id)->get();
            //dd($lugares);
            if ($lugares) {
                foreach ($lugares as $lugar) {
                    $lugar->place_status = 2;
                    $lugar->save();
                }
            }
            $local = Locals::find($registro->local_id);
            $local->local_status = 2;
            $local->save();
            
            $merchant = Merchants::find($registro->merchant_id );
            
            return redirect()->route('payment.locals', ['curp' => $merchant->merchant_curp])->with('success', 'El local del comerciante se ha dado de baja correctamente.');

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('payment.locals', ['curp' => $merchant->merchant_curp])->with('error','El local del comerciante no se ha dado de baja.', compact('th'));
        }
        
        
    }

    public function getLocalDetails($local_id) {
        //dd($local_id);
        $local = Locals::find($local_id);
        $tianguis = Tianguis::all()->where('tiangui_status', 1);
        $markets = Markets::all()->where('market_status', 1);
        
        return view('locales.editLocal', compact('local', 'tianguis', 'markets'));
    }

    public function updateStaticLocal(Request $request) {
        // dd($request);
        $local = Locals::with('RLocalRecords.RRecordsMerchant')->find($request->local_id);
        $rRecordsMerchant = $local->RLocalRecords->first()->RRecordsMerchant;
        $local->local_location = $request->ubicacion;
        if ($local->category_id <> 1 && $local->category_id <> 4) {
            $local->local_startingHour = $request->IHour;
            $local->local_endingHour = $request->FHour;
            
        } else {
            if ($local->category_id == 1) {
                $local->tiangui_id = $request->tianguis;
            }
            if ($local->category_id == 4) {
                $local->market_id = $request->tianguis;
            }
        }
        
        if ($request->filled('giro') ) {
            $business = "";
            $giros = $request->giro;
            $contador = count($request->giro);
            for ($i=0; $i < $contador; $i++) { 
                $business = $business.strtolower($giros[$i]).',';
            } 
            $local->local_activity = strtolower($business);
        } 
        if ($request->otrosg <> null) {
            $business = "";
            $business = $business.strtolower($request->otrosg).',';
            $local->local_activity = strtolower($business);
        } 
        $days = "";
        $days_l = "";
        $wdays = $request->day;

        if ($local->category_id <> 1 && $local->category_id <> 4) {
            $contador = count($request->day);
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
        

        // dd($local, $request);
        try {
            $local->save(); 
            return redirect()->route('payment.locals', $rRecordsMerchant->merchant_curp )
                ->with('success', 'Se ha modificado las medidas del local correctamente.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Los datos del local no se han podido modificar.', compact('th'));
        
        }

    }

    public function deactivateTPlace($id_lugar) {
        //dd($id_lugar);
        $lugar = Places::find($id_lugar);
        $lugar->place_status = 2;
        $lugar->save();
        
        $local_id = $lugar->local_id;
        $local = Locals::find($local_id);
        $local->local_places = $local->local_places - 1;
        $local->local_area = ($local->local_area) - ($lugar->place_dimx * $lugar->place_dimy);
        $local->save();

        return back()->with('success', 'El local del comerciante se ha dado de baja correctamente.');
        //dd($lugar);
    }
    
    public function addPlaceLocal(Request $request) {
        // dd($request);

        $local = Locals::find($request->local_id);
        $local->local_location = $request->location;
        $local->local_places = $local->local_places + 1;
        $local->local_area = ($local->local_area) + ($request->dimx * $request->dimy);
        // dd($request, $local);
        try {
            $local->save();

            $lugar = new Places();
            $lugar->place_dimx = $request->dimx;
            $lugar->place_dimy = $request->dimy;
            $lugar->local_id = $local->local_id;
            
            // dd($request, $local, $lugar);
            $lugar->save();

            return redirect()->route('local.localDetails', $local->local_id )->with('success', 'Se ha añadido un nuevo lugar correctamente.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error','El local del comerciante no se ha registrado correctamente.', compact('th'));
        
        }
        
    }

    public function updatePlace(Request $request) {
        // dd($request);
        $lugar = Places::find($request->place_id);
        $X = 0;
        $Y = 0;
        $area = 0;
        $lugar->place_dimx = $request->dimx;
        $lugar->place_dimy = $request->dimy;
        
        try {
            $lugar->save();
            
            $local = Locals::find($request->local_id);
            
            $lugares = Places::all()->where('local_id', $local->local_id);
            foreach ($lugares as $lugar) {
                $X = $lugar->place_dimx;
                $Y = $lugar->place_dimy;
                $area += ($X * $Y);
            }
            $local->local_area = $area;
            $local->local_dimx = $X;
            $local->local_dimy = $Y;
            $local->save();
            
            //dd($lugar, $X, $Y, $area, $local);
            return redirect()->route('local.localDetails', $local->local_id )->with('success', 'Se ha modificado el lugar correctamente.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error','El lugar del comerciante no se ha modificado.', compact('th'));
        
        }
    }

    public function updateLocalMeasurements(Request $request) {
        // dd($request);

        // $local = Locals::find($request->local_id);
        $local = Locals::with('RLocalRecords.RRecordsMerchant')->find($request->local_id);
        $rRecordsMerchant = $local->RLocalRecords->first()->RRecordsMerchant;

        $local->local_dimx = $request->dimx;
        $local->local_dimy = $request->dimy;
        $local->local_area = ($request->dimx * $request->dimy);

        // dd($local, $rRecordsMerchant);

        try {
            $local->save(); 
            return redirect()->route('payment.locals', $rRecordsMerchant->merchant_curp )
                ->with('success', 'Se ha modificado las medidas del local correctamente.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Las medidas del local no se ha modificado.', compact('th'));
        
        }
        
    }




}
