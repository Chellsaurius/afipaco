<?php

namespace App\Http\Controllers;

use App\Models\Tianguis;
use Illuminate\Http\Request;

class TianguisController extends Controller
{
    public function index (){
        $daysOfWeek = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        $tianguis = Tianguis::all()->where('tiangui_status', 1)->where('tiangui_id', '<>', 1);
        //dd($montos);
        return view('tianguis.list', compact('tianguis', 'daysOfWeek'));
    }

    public function nTianguis() {
        $daysOfWeek = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];

        return view('tianguis.newTianguis', compact('daysOfWeek'));
    }

    public function store(Request $request) {
        // dd($request);
        $dias = ["", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
        
        
        try {
            
            
            $tiangui = new Tianguis();

            $tiangui->nombre_tianguis = strtolower($request->nameTianguis);
            $tiangui->dia = $request->dayTianguis;
            $tiangui->tiangui_dayText = $dias[$request->dayTianguis];
            $tiangui->thora_inicio = $request->IHourTianguis;
            $tiangui->thora_final = $request->FHourTianguis;
            dd($tiangui);
            $tiangui->save();
            
            $tianguis = Tianguis::all()->where('tiangui_status', 1);
            
            return redirect()->route('tianguis.index', compact('tianguis'))->with('success', 'Tianguis agregado correctamente');

        } catch (\Throwable $th) {
            //throw $th;

            $tianguis = Tianguis::all();
            return redirect()->route('tianguis.index', compact('tianguis', 'th'))->with('error', 'Tianguis no agregado');
        }
            
    }

    public function deactivateTianguis($id)
    {
        
        try {
            $tiangui = Tianguis::find($id);
            $tiangui->tiangui_status = 2;
            $tiangui->save();
            
            $tianguis = Tianguis::all()->where('tiangui_status', 1);
            return redirect()->route('tianguis.index', compact('tianguis'))->with('success', 'Tianguis Dado de baja correctamente');

        } catch (\Throwable $th) {
            //throw $th;

            $tianguis = Tianguis::all()->where('tiangui_status', 1);
            return redirect()->route('tianguis.index', compact('tianguis', 'th'))->with('error', 'Tianguis no agregado');
        }
    }

    public function updateTianguis(Request $request)
    {
        
        // dd($request);
        
        $daysOfWeek = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'];
        try {
            $tiangui = Tianguis::find($request->tiangui_id);
            $tiangui->tiangui_name = $request->name;
            $tiangui->tiangui_day = $request->dia;
            $tiangui->tiangui_dayText = $daysOfWeek[$request->dia - 1];
            $tiangui->tiangui_startingHour = $request->IHourTianguis;
            $tiangui->tiangui_endingHour = $request->FHourTianguis;
            // dd($request, $tiangui);
            $tiangui->save();

            $tianguis = Tianguis::all()->where('tiangui_status', 1);
            return redirect()->route('tianguis.index', compact('tianguis'))->with('success', 'Tianguis actualizado');

        } catch (\Throwable $th) {
            //throw $th;

            $tianguis = Tianguis::all()->where('tiangui_status', 1);
            return redirect()->route('tianguis.index', compact('tianguis', 'th'))->with('error', 'Tianguis no actualizado');
        }
    }
}
