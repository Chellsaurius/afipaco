@extends('layouts.carcasa')

@section('css')
@endsection

@section('title')
    <title>Nuevo tianguis</title>
@endsection

@section('content')
    <div class="container ">
        <div class="shadow-lg rounded">
            <div class="card">
                <div class="card-header">Nuevo tianguis</div>

                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        <a href="{{ route('tianguis.index') }}" 
                            class="btn btn-secondary d-flex align-items-end">
                            Regresar
                        </a>
                    </div>
                    <br>
        
                    <form action="{{ route('tianguis.store') }}" method="POST" >
                        @csrf
                        <div class="d-flex justify-content-start row">
                            <div class="mb-3 col-7 border">
                                <label for="nameTianguis" class="form-label"> Nombre del tianguis</label>
                                <input type="text" name="nameTianguis" autofocus="on" autocomplete="off" class="form-control text-uppercase" 
                                    id="nameTianguis" aria-describedby="nameHelp" required>
                                <div id="nameHelp" class="form-text">Formato: nombre completo.</div>
                            </div>
                            
                            <div class="mb-3 col-3 border">
                                <label for="dayTianguis" class="form-label"> Día del tianguis </label>
                                <select name="dayTianguis" id="dayTianguis" class="form-control" >
                                    <option value="1" >LUNES</option>
                                    <option value="2" >MARTES</option>
                                    <option value="3" >MIÉRCOLES</option>
                                    <option value="4" >JUEVES</option>
                                    <option value="5" >VIERNES</option>
                                    <option value="6" >SÁBADO</option>
                                    <option value="7" >DOMINGO</option>
                                    
                                </select>
                                
                            </div>
                        
                            <div class="mb-3 col-3 border">
                                <label for="IHourTianguis" class="form-label"> Selecciona la hora de inicio. </label>
                                <input type="time" id="IHourTianguis" name="IHourTianguis" class="form-control"
                                    aria-describedby="iHourHelp" min="01:00" max="23:59" required>
                                <div id="iHourHelp" class="form-text">Formato: 24 horas. </div>
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="FHourTianguis" class="form-label"> Selecciona la hora de finalización. </label>
                                <input type="time" id="FHourTianguis" name="FHourTianguis" class="form-control"
                                    aria-describedby="fHourHelp" min="01:00" max="24:00" required>
                                <div id="fHourHelp" class="form-text">Formato: 24 horas.</div>
                            </div>
                            <div class="col-12 ml-4">
                                <button type="submit" class="btn btn-primary col-3">Siguiente</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @section('js')
        @endsection
    </div>
@endsection