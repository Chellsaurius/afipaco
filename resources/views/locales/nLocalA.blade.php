@extends('layouts.carcasa')

@section('css')
    
@endsection

@section('title')
    <title>Registrar local</title>
@endsection

@section('content')   
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="container col-md-12">
        <div class="border shadow-lg p-3 mb-5 bg-body rounded">
            <div class="d-flex justify-content-left row col-md-12">
                <h5 class="col-6">Nuevo local: </h5>
                <form class="row" action="{{ route('sLocal') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3 col-6 border">
                        <label for="dimx" class="form-label">Dimensión X</label>
                        <input type=number step=0.01 name="dimx" autocomplete="off" autofocus="on" min=0.01
                            class="form-control" id="dimx" aria-describedby="xHelp" placeholder="X.XX" 
                            required>
                        <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                        @error('dimx')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3 col-6 border">
                        <label for="dimy" class="form-label">Dimensión Y</label>
                        <input type=number step=0.01 name="dimy" autocomplete="off" autofocus="off" min=0.01
                            class="form-control" id="dimy" aria-describedby="yHelp" placeholder="X.XX" 
                            required>
                        <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                        @error('dimy')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <input type="hidden" id="cat" name="cat" value="3">
                    <div class="mb-3 col-10 border">
                        <label for="ubicacion" class="form-label">Ruta de la ubicación o recorrido.</label>
                        <input type=text name="ubicacion" autocomplete="off" autofocus="off"
                            class="form-control text-uppercase" id="ubicacion" aria-describedby="ubiHelp"  
                            required>
                        <div id="ubiHelp" class="form-text">Ingresar la ruta que recorre el comerciante.</div>
                        @error('ubicacion')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="mb-3 col-5">
                        <label for="IHour" class="form-label"> Selecciona la hora de inicio. </label>
                        <input type="time" id="IHour" name="IHour" 
                            aria-describedby="iHourHelp" required>
                        <div id="iHourHelp" class="form-text">Formato: 12 horas (07:00 a.m.). </div>
                    </div>
                    <div class="mb-3 col-5">
                        <label for="FHour" class="form-label"> Selecciona la hora de finalización. </label>
                        <input type="time" id="FHour" name="FHour" 
                            aria-describedby="fHourHelp" required>
                        <div id="fHourHelp" class="form-text">Formato: 12 horas (04:00 p.m.).</div>
                    </div>
                    
                        
                    <div class="col-12 ml-4">
                        <button type="submit" class="btn btn-primary col-3">Siguiente</button>
                    </div>
                </form>
            </div>
        </div>
        @section('js')
        @endsection
    </div>

@endsection
