<?php

namespace App\Http\Controllers;

use App\Models\Markets;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    //
    public function index() {
        // dd('holiwis');
        $markets = Markets::all()->where('market_status', 1)->where('market_id', '<>', 1);
        return view('markets.indexMarkets', compact('markets'));
    }

    public function newMarket() {
        // dd('holi');
        return view('markets.newMarket');
    }

    public function saveMarket(Request $request) {
        // dd($request);
        $market = new Markets();
        $market->market_name = $request->name;
        $market->market_startingHour = $request->startingHour;
        $market->market_endingHour = $request->endingHour;
        $market->save();

        $markets = Markets::all()->where('market_status', 1);
        return view('markets.indexMarkets', compact('markets'))->with('success', 'Lugar guardado correctamente.');
    }

    public function editMarket(Request $request) {

        $market = Markets::find($request->id);
        $market->market_name = strtolower($request->name);
        $market->market_startingHour = $request->startingHour;
        $market->market_endingHour = $request->endingHour;
        $market->save();

        $markets = Markets::all()->where('market_status', 1);
        return view('markets.indexMarkets', compact('markets'))->with('success', 'Lugar actualizado correctamente.');
    }

    public function disableMarket($id) {
        $market = Markets::find($id);
        $market->market_status = 2;
        $market->save();

        $markets = Markets::all()->where('market_status', 1);
        return view('markets.indexMarkets', compact('markets'))->with('success', 'Lugar deshabilitado correctamente.');
        
    }
    
    public function enableMarket($id) {
        $market = Markets::find($id);
        $market->market_status = 1;
        $market->save();

        $markets = Markets::all()->where('market_status', 1);
        return view('markets.indexMarkets', compact('markets'))->with('success', 'Lugar habilitado correctamente.');
    }
    
    public function disabledMarketsList() {
        $markets = Markets::all()->where('market_status', 2)->where('market_id', '<>', 1);
        return view('markets.disabledMarkets', compact('markets'));
    }
    
    
}
