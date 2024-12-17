<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InspectorsController extends Controller
{
    public function index(){
        $inspectores = User::all()->where('user_rol', 2)->where('user_status', 1);
        
        return view('inspectors.inspectorList', compact('inspectores'));

    }

    public function nInspector() {
        return view('inspectors.newInspector');
    }

    public function saveInspector(Request $request) {
        //dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'pass' => ['required', 'string', 'min:6'],
        ]);
        //dd($request);
        $inspectores = User::all()->where('user_rol', 2)->where('user_status', 1);
        $inspector = new User();

        $inspector->name = strtolower($request->name);
        $inspector->email = strtolower($request->email);
        $inspector->user_rol = 2;

        if ($request->pass == $request->pass_verified) {
            
            $pass = Hash::make($request->pass);
            $inspector->password = $pass;
            try {
                //dd($inspector);
                $inspector->save();
    
                return redirect()->route('inspectors.index', compact('inspectores'))->with('success', 'Inspector agregado correctamente.');
            } catch (\Throwable $th) {
                //throw $th;
                $user = User::select('id')->orderBy('id','desc')->first();
                $delUser = User::where('id', $user)->delete();
    
                return redirect()->back()->with('error', 'Inspector no agregado, favor de verificar correctamente.', compact('inspectores'));
            }
        }
        else
        {
            return redirect()->back()->with('error', 'Inspector no agregado, favor de verificar contrase単as.', compact('inspectores'));
        }
        
    }

    public function dischargeInspector($id) {
        //dd($id);
        $inspectores = User::all()->where('role', 2)->where('user_status', 1);
        
        try {
            
            $affected = User::find($id);
            $affected->user_status = 2;
            $affected->save();

            return redirect()->route('inspectors.index', compact('inspectores'))->with('success', 'Inspector dado de baja correctamente.');

        } catch (\Throwable $th) {
            //throw $th;
            $user = User::select('id')->orderBy('id','desc')->first();
            $delUser = User::where('id', $user)->delete();

            return redirect()->back()->with('error', 'Inspector no agregado, favor de verificar correctamente.', compact('inspectores'));
        }

    }

    public function listDischargedInspectors() {
        $inspectores = User::all()->where('role', 2)->where('user_status', 2);

        return view('inspectors.lDischargedInspectors', compact('inspectores'));
    }

    public function activateDischargedInspector($id) {
        //dd($id);
        try {
            
            $affected = User::find($id);
            $affected->user_status = 1;
            $affected->save();
            
            $inspectores = User::all()->where('role', 2)->where('user_status', 1);

            return redirect()->route('inspectors.index', compact('inspectores'))->with('success', 'Inspector reactivado correctamente.');

        } catch (\Throwable $th) {
            //throw $th;
            $inspectores = User::all()->where('role', 2)->where('user_status', 2);

            return redirect()->back()->with('error', 'Error al reactivar el inspector.', compact('inspectores', 'th'));
        }

    }

    public function updateInspector(Request $request)
    {
        
        //dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);
        try {
            
            $id = $request->id;
            $name = $request->name;
            $name = strtolower($name);
            
            $user = User::find($id);
            $user->name = $name;
            
            //dd($user);
            $user->save();
            
            $inspectores = User::where('role', 2)->where('user_status', 1)->get();
            
            return redirect()->route('inspectors.index', compact('inspectores'))->with('success', 'Inspector actualizado correctamente');

        } catch (\Throwable $th) {
            //throw $th;
            //dd($request, $th);
            $inspectores = User::all()->where('role', 2)->where('user_status', 2);
            return redirect()->back()->with('error', 'Error al acualizar al inspector.');
        }
        
        
    }
}
