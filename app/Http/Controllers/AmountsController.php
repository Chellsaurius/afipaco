<?php

namespace App\Http\Controllers;

use App\Models\Amounts;
use App\Models\Monto;
use App\Models\Regulations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class AmountsController extends Controller
{
    //
    public function index (){
        $montos = Amounts::orderBy('amount_year', 'desc')->where('amount_id', '<>', 1)->get();
        // dd($montos);
        return view('amounts.montos', compact('montos'));
    }

    public function store(Request $request){
        $monto = new Amounts();
        
        //$highscores = HighScore::orderBy('score', 'asc')->get();
        $monto->amount_cost = $request->monto;
        $monto->amount_year = $request->year;
        $monto->regulation_id  = $request->regulation;
        // dd($request, $monto);
        
        $monto->save();
        
        $montos = Amounts::all()->where('amount_status', 1);
        return redirect()->route('amounts.index', compact('montos'))->with('success', 'Monto agregado correctamente');
        

    }

    public function nmonto(){
        
        $regulations = Regulations::where('regulation_status', 1)
            ->whereNotIn('regulation_id', DB::table('amounts')
                ->where('amount_year', Carbon::now()->year)
                ->where('amount_status', 1)
                ->where('amount_id', '<>', 1)
                ->pluck('regulation_id'))
            ->get();
        if ($regulations->isEmpty()) {
            $regulations = Regulations::where('regulation_status', 1)->get();
            $montos = Amounts::where('amount_status', 1)->orderBy('amount_year', 'desc')->get();
            // dd($regulations ,$montos);
            return view('amounts.nmonto', compact('regulations', 'montos'));
        } else {
            $year = Carbon::now()->year;
            // dd($regulations ,$year);
            return view('amounts.nmonto', compact('regulations', 'year'));
        }
        
    }

    public function enableAmount($id)
    {
        $affected = Amounts::find($id);
        $affected->amount_status = 1;
        $affected->save();

        $montos = Amounts::all();

        return redirect()->route('amounts.index', compact('montos'))->with('success', 'Monto activado correctamente.');
    }

    public function disableAmount($id)
    {
        $affected = Amounts::find($id);
        $affected->amount_status = 2;
        $affected->save();

        $montos = Amounts::all();

        return redirect()->route('amounts.index', compact('montos'))->with('success', 'Monto desactivado correctamente.');
    }
}
