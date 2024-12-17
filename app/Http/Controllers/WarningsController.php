<?php

namespace App\Http\Controllers;

use App\Models\Merchants;
use App\Models\Warnings;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class WarningsController extends Controller
{
    public function index (){
        $apercibimientos = Warnings::all()->where('estatus_apercibimiento', 1);
        //dd($apercibimientos);
        return view('warnings.lWarnings', compact('apercibimientos'));
    }

    public function modifyWarning($id) {
        //dd($id);
        /*$apercibimiento = Warnings::where('id_apercibimiento', $id)->first();
        $affected = DB::table('apercibimientos')
            ->where('id_apercibimiento', $id)
            ->update(['estatus_apercibimiento' => 2]);*/

        $apercibimiento = Warnings::find($id);
        $apercibimiento->estatus_apercibimiento = 2;
        $apercibimiento->save();
        

        $id = $apercibimiento->merchant_id ;
        /*$merchant = Comerciante::where('merchant_id ', $id)->first();
        $warnings = $merchant->apercibimientos - 1;
        $affectedTwo = DB::table('comerciantes')
            ->where('merchant_id ', $merchant->merchant_id )
            ->update(['apercibimientos' => $warnings]);*/

        $merchant = Merchants::find($id);
        $merchant->apercibimientos = $merchant->apercibimientos - 1;

        if ($merchant->apercibimientos <= 1 ) {
            
            /*$affectedThree = DB::table('comerciantes')
                ->where('merchant_id ', $id)
                ->update(['merchant_status' => 1]);*/
            $merchant->merchant_status = 1;
        }

        $merchant->save();

        $apercibimientos = Warnings::all()->where('estatus_apercibimiento', 1);
        //dd($apercibimiento, $apercibimientos);
        return redirect()->route('warnings.list', compact('apercibimientos'))->with('success', 'Apercibimiento retirado correctamente');

    }

    public function generateWarning(Request $request) {
        //dd($request);
        $id = $request->merchant_id ;
        $merchant = Merchants::find($id);
        
        $apercibimiento = new Warnings();
        $apercibimiento->id_user = $request->id_user;
        $apercibimiento->comentario = $request->comentario;
        $apercibimiento->merchant_id  = $request->merchant_id ;
        try {
                
            $apercibimiento->save();

            $merchant->apercibimientos = $merchant->apercibimientos + 1;
            
            /*$affected = DB::table('comerciantes')
                ->where('merchant_id ', $id)
                ->update(['apercibimientos' => $warnings]);*/
            
            
            if ($merchant->apercibimientos >= 2) {
                
                /*$affectedTwo = DB::table('comerciantes')
                    ->where('merchant_id ', $id)
                    ->update(['merchant_status' => 2]);*/
                $merchant->merchant_status = 2;
                    
            }

            $merchant->save();
            //dd($local);
            
            return redirect()->route('home')->with('success', 'El apercibimiento del comerciante se ha agregado correctamente.');
            
        } catch (ModelNotFoundException $exception) {
            //throw $th;
            $idApercibimiento = Warnings::select('id_apercibimiento')->orderBy('id_apercibimiento','desc')->first();
            //dd($delLocal);
            $delApercibimiento = Warnings::where('id_apercibimiento', $idApercibimiento)->delete();
            return redirect()->back()->withError($exception->getMessage())->withInput();
        }
    }

    public function especificWarning($id)
    {
        //dd($id);
        $comerciante = Merchants::where('merchant_curp', $id)->first();
        $apercibimientos = Warnings::where('estatus_apercibimiento', 1)->where('merchant_id ', $comerciante->merchant_id )->get();
        
        return view('warnings.lWarningsEspecific', compact('apercibimientos'));
    }
}
