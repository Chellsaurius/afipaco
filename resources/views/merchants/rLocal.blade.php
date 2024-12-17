@extends('layouts.carcasa')

@section('css')
@endsection

@section('title')
    <title>Registrar local</title>
@endsection

@section('content')   
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Nuevo local del comerciante con CURP: {{ Str::upper($curp) }}. </div>
                    
                    <form action="{{ route('sMLocal', $curp) }}" method="POST">
                        @csrf
                        <input type="hidden" name="curp" id="curp" value="{{ $curp }}">
                        
                        <div class="col-5 mb-3 p-3 border ms-3">
                            <label for="categoria" class="form-label">Categoria del local: </label>
                            <select name="categoria" id="categoria" class="form-control" onchange="changeForm(this.selectedIndex)" required>
                                <option value="" selected disabled>Seleccione una opción</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->category_id }}" id="{{ $type->category_id }}">{{ $type->category_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        @include('merchants.js.changeLocalForm')
                        <br>
                        <div id="Tianguista" style="display:none">
                            <div class="col-12 row">
                                <div class="mb-3 col-11 ms-2 p-3" >
                                    <label for="ubicacion" class="form-label"> Ingresar el/los números de locales. </label>
                                    <input type=text name="ubicacion" id="TUbicacion" autocomplete="off" min=0.01
                                        class="form-control text-uppercase" id="TUbicacion" aria-describedby="ubiHelp" 
                                        required>
                                    <div id="ubiHelp" class="form-text"> Ejemplo: fila "A", número 8 y fila "B" número 4. </div>
                                    @error('ubicacion')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-5 ms-2 p-3">  
                                    <label for="tianguis" class="form-label">Tianguis: </label>
                                    <select name="tianguis" id="tianguis" class="form-control" required>
                                        <option value="" disabled selected>Seleccione un tianguis</option>
                                        @foreach ($tianguis as $tiangui)
                                            <option value="{{ $tiangui->tiangui_id }}" class="text-uppercase"> {{ Str::upper($tiangui->tiangui_name) }} ({{ Str::upper($tiangui->tiangui_dayText) }})</option>
                                            
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-5 mb-3 p-3">
                                    <label for="lugares" class="form-label">Lugares: </label>
                                    <select name="lugares" id="lugares" class="form-control" onchange="places()" required>
                                        <option value="" disabled selected>0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            
                            <span id="dimensiones" class="row">
                            </span>
                            <br>
                            <hr>
                        </div>

                        <div id="Semifijo" style="display:none">
                            <div class="row ms-3">
                                <div class="mb-3 col-3 " >
                                    <label for="IHour" class="form-label"> Selecciona la hora de inicio. </label>
                                    <input type="time" class="form-control" id="SIHour" name="IHour" required 
                                        aria-describedby="iHourHelp" >
                                    <div id="iHourHelp" class="form-text">Formato: 12 horas (07:00 a.m.). </div>
                                </div>
                                <div class="mb-3 col-3 ">
                                    <label for="FHour" class="form-label"> Selecciona la hora de finalización. </label>
                                    <input type="time" class="form-control" id="SFHour" name="FHour" required
                                        aria-describedby="fHourHelp" > 
                                    <div id="fHourHelp" class="form-text">Formato: 12 horas (04:00 p.m.).</div>
                                </div>
                            </div>
                            
                            <div class="row ms-3">
                                <div class="mb-3 col-3 ">
                                    <label for="dimx" class="form-label">Dimensión X</label>
                                    <input type=number step=0.01 name="dimx" autocomplete="off"  min=0.01
                                        class="form-control" id="SDimx" aria-describedby="xHelp" placeholder="X.XX" 
                                        required>
                                    <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                                    @error('dimx')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-3 ">
                                        <label for="dimy" class="form-label">Dimensión Y</label>
                                    <input type=number step=0.01 name="dimy" autocomplete="off" min=0.01
                                        class="form-control" id="SDimy" aria-describedby="yHelp" placeholder="X.XX" 
                                        required>
                                    <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                                    @error('dimy')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-12 p-3" >
                                <label for="ubicacion" class="form-label"> 
                                    Ingresar la ubicación del comerciante.
                                </label>
                                <input type=text name="ubicacion" autocomplete="off" min=0.01
                                    class="form-control text-uppercase" id="SUbicacion" aria-describedby="ubiHelp" 
                                    required>
                                <div id="ubiHelp" class="form-text"> 
                                    Ubicación exacta del local del comerciante.
                                </div>
                                @error('ubicacion')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <br>
                            <hr>
                        </div>
                        
                        <div id="Ambulante" style="display:none" disabled>
                            <div class="row ms-3">
                                <div class="mb-3 col-3 " >
                                    <label for="IHour" class="form-label"> Selecciona la hora de inicio. </label>
                                    <input type="time" class="form-control" id="AIHour" name="IHour" required 
                                        aria-describedby="iHourHelp" >
                                    <div id="iHourHelp" class="form-text">Formato: 12 horas (07:00 a.m.). </div>
                                </div>
                                <div class="mb-3 col-3 ">
                                    <label for="FHour" class="form-label"> Selecciona la hora de finalización. </label>
                                    <input type="time" class="form-control" id="AFHour" name="FHour" required
                                        aria-describedby="fHourHelp" > 
                                    <div id="fHourHelp" class="form-text">Formato: 12 horas (04:00 p.m.).</div>
                                </div>
                            </div>
                            <div class="row ms-3">
                                <div class="mb-3 col-3 ">
                                    <label for="dimx" class="form-label">Dimensión X</label>
                                    <input type=number step=0.01 name="dimx" autocomplete="off"  min=0.01
                                        class="form-control" id="ADimx" aria-describedby="xHelp" placeholder="X.XX" 
                                        required>
                                    <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                                    @error('dimx')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-3 ">
                                        <label for="dimy" class="form-label">Dimensión Y</label>
                                    <input type=number step=0.01 name="dimy" autocomplete="off" min=0.01
                                        class="form-control" id="ADimy" aria-describedby="yHelp" placeholder="X.XX" 
                                        required>
                                    <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                                    @error('dimy')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12 " >
                                    <label for="ubicacion" class="form-label"> 
                                        Ingresar la ruta del comerciante.
                                    </label>
                                    <input type=text name="ubicacion" autocomplete="off" min=0.01
                                        class="form-control text-uppercase" id="AUbicacion" aria-describedby="ubiHelp" 
                                        required>
                                    <div id="ubiHelp" class="form-text"> 
                                        Ruta que recorre el comerciante en su recorrido
                                    </div>
                                    @error('ubicacion')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <hr>
                        </div>

                        <div id="Ocasional" style="display:none" class="row ps-3" disabled>
                            <div class="col-12 row">
                                <div class="mb-3 col-11 ms-2 p-3" >
                                    <label for="ubicacion" class="form-label"> Ingresar el/los números de locales. </label>
                                    <input type=text name="ubicacion" id="OUbicacion" autocomplete="off" min=0.01
                                        class="form-control text-uppercase" aria-describedby="ubiHelp" 
                                        required>
                                    <div id="ubiHelp" class="form-text"> Ejemplo: fila "A", número 8 y fila "B" número 4. </div>
                                    @error('ubicacion')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-5 ms-2 p-3">  
                                    <label for="OLugar" class="form-label">Lugar: </label>
                                    <select name="OLugar" id="OLugar" class="form-control" required>
                                        <option value="" disabled selected>Seleccione un lugar</option>
                                        @foreach ($markets as $market)
                                            <option value="{{ $market->market_id }}" class="text-uppercase"> {{ Str::upper($market->market_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-5 mb-3 p-3">
                                    <label for="lugares" class="form-label">Lugares: </label>
                                    <select name="oLugares" id="OLugares" class="form-control" onchange="OPlaces()" required>
                                        <option value="" disabled selected>0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            
                            <span id="ODimensiones" class="row">
                            </span>
                            <br>
                            <hr>
                        </div>

                        <div id="Otro" style="display:none" class="row px-3" disabled>
                            <div class="row">
                                <div class="mb-3 col-3 " >
                                    <label for="IHour" class="form-label"> Selecciona la hora de inicio. </label>
                                    <input type="time" class="form-control" id="OtrosIHour" name="IHour" value="00:00"  required 
                                        aria-describedby="iHourHelp" >
                                    <div id="iHourHelp" class="form-text">Formato: 12 horas (07:00 a.m.). </div>
                                </div>
                                <div class="mb-3 col-3 ">
                                    <label for="FHour" class="form-label"> Selecciona la hora de finalización. </label>
                                    <input type="time" class="form-control" id="OtrosFHour" name="FHour"value="00:00"  required
                                        aria-describedby="fHourHelp" > 
                                    <div id="fHourHelp" class="form-text">Formato: 12 horas (04:00 p.m.).</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-3 ">
                                    <label for="dimx" class="form-label">Dimensión X</label>
                                    <input type=number step=0.01 name="dimx" autocomplete="off"  min=0.01
                                        class="form-control" id="OtrosDimx" aria-describedby="xHelp" placeholder="X.XX" 
                                        required>
                                    <div id="xHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                                    @error('dimx')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 col-3 ">
                                        <label for="dimy" class="form-label">Dimensión Y</label>
                                    <input type=number step=0.01 name="dimy" autocomplete="off" min=0.01
                                        class="form-control" id="OtrosDimy" aria-describedby="yHelp" placeholder="X.XX" 
                                        required>
                                    <div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                                    @error('dimy')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-12 " >
                                <label for="ubicacion" class="form-label"> 
                                    Ingresar la ubicación del local del comerciante.
                                </label>
                                <input type=text name="ubicacion" autocomplete="off" min=0.01
                                    class="form-control text-uppercase" id="OtrosUbicacion" aria-describedby="ubiHelp" 
                                    required>
                                <div id="ubiHelp" class="form-text"> 
                                    Ejemplo: comunicación norte esquina técnicos
                                </div>
                                @error('ubicacion')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                        </div>
                        
                        
                        <div class="mb-3 col-12 form-control " id="selectableDays" style="display:block"> {{-- parte del codigo para días --}}
                            <div class="row " >
                                <div class="@error('dia') is-invalid @enderror"></div>
                                <label for="dias" class="form-label" aria-describedby="diasHelp">Días laborales</label>
                                <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                    <input type="checkbox" name="dia[]" value="1" class="form-check-input m-1" id="day1">
                                    <label class="form-check-label" for="day1"> Lunes</label>
                                </div>
                                <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                    <input type="checkbox" name="dia[]" value="2" class="form-check-input m-1" id="day2">
                                    <label class="form-check-label" for="day2"> Martes</label>
                                </div>
                                <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                    <input type="checkbox" name="dia[]" value="3" class="form-check-input m-1" id="day3">
                                    <label class="form-check-label" for="day3"> Miércoles</label>
                                </div>
                                <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                    <input type="checkbox" name="dia[]" value="4" class="form-check-input m-1" id="day4">
                                    <label class="form-check-label" for="day4"> Jueves</label>
                                </div>
                                <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                    <input type="checkbox" name="dia[]" value="5" class="form-check-input m-1" id="day5">
                                    <label class="form-check-label" for="day5"> Viernes</label>
                                </div>
                                <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                    <input type="checkbox" name="dia[]" value="6" class="form-check-input m-1" id="day6">
                                    <label class="form-check-label" for="day6"> Sábado</label>
                                </div>
                                <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                    <input type="checkbox" name="dia[]" value="7" class="form-check-input m-1" id="day7">
                                    <label class="form-check-label" for="day7"> Domingo</label>
                                </div>
                                @error('dia')
                                    <span class="invalid-feedback col-12 p-3" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <div id="diasHelp" class="form-text">Ingrese los días que laborará el comerciante.</div>
                            </div>
                            
                        </div>
                        <div class="mb-3 col-12 border form-control ">  {{-- parte del código para los giros --}}
                            <div class="row " >
                                <div class="@error('merchant_activity') is-invalid @enderror"></div>
                                <label for="bussinnes" class="form-label ">Giro(s)</label>
                                <div class="d-flex justify-content-left col-2 border align-items-center">
                                    <input type="checkbox" name="giro[]" value="ropa usada" class="form-check-input m-1" id="ropa usada">
                                    <label class="form-check-label" for="ropa usada"> Ropa usada</label>
                                </div>
                                <div class="d-flex justify-content-left border col-2 align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="herramientas" class="form-check-input m-1" id="herramientas">
                                    <label class="form-check-label" for="herramientas">Herramientas</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="comida" class="form-check-input m-1" id="comida">
                                    <label class="form-check-label" for="comida">Comida</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="bisutería" class="form-check-input m-1" id="bisuteria">
                                    <label class="form-check-label" for="bisuteria">Bisutería</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="juguetes" class="form-check-input m-1" id="juguetes">
                                    <label class="form-check-label" for="juguetes">Juguetes</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="plasticos" 
                                        class="form-check-input m-1" id="plasticos">
                                    <label class="form-check-label" for="plasticos">Plasticos</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="tacos" class="form-check-input m-1" id="tacos">
                                    <label class="form-check-label" for="tacos">Tacos</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="gorditas" class="form-check-input m-1" id="gorditas">
                                    <label class="form-check-label" for="gorditas">Gorditas</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="dulces" class="form-check-input m-1" id="dulces">
                                    <label class="form-check-label" for="dulces">Dulces</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="fruta" class="form-check-input m-1" id="fruta">
                                    <label class="form-check-label" for="fruta">Frutas</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="verdura" class="form-check-input m-1" id="verdura">
                                    <label class="form-check-label" for="verdura">Verduras</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="artesanías" class="form-check-input m-1" id="artesanias">
                                    <label class="form-check-label" for="artesanias">Artesanías</label>
                                </div>
                                
                                <div class="mb-3 col-12 p-3">
                                    <input type="checkbox" value="otros" class="form-check-input m-1 @error('otros') is-invalid @enderror" id="otros" >
                                    <label class="form-label" for="otros">Otros</label>
                                    <input type="text" name="otrosg" class="form-control text-uppercase" id="otrosg" aria-describedby="giroHelp" disabled>
                                    <div id="giroHelp" class="form-text">Ingrese el o los giros del comerciante si no están en la parte de arriba, separados por "," sin "Y" al final "esto,lo otro".</div>
                                </div>
                                <script>
                                    document.getElementById('otros').onchange = function() {
                                        document.getElementById('otrosg').disabled = !this.checked;
                                    };
                                </script>
                            </div>
                            
                        </div>
                        @error('merchant_activity')
                            <span class="invalid-feedback mb-3 col-12 p-3" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        @error('otros')
                            <span class="invalid-feedback mb-3 col-12 p-3" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <br>
                        <div class="col-12 ms-3">
                            <div class="mb-3 form-check col-5 ">
                                <input type="checkbox" class="form-check-input" id="FinalCheck" required>
                                <label class="form-check-label" for="FinalCheck">Los datos del comerciante son correctos </label>
                            </div>
                        </div>
                        <div class="col-12 ms-3">
                            <button type="submit" class="btn btn-primary col-3">Siguiente</button>
                        </div>
                        <br>
                    </form>
                </div>  
            </div>
        </div>
        
    </div>
    
    <script>
        function places() {
            
            var value = document.getElementById("lugares").value
            var output='';
            console.log(value);
            for(var i=1; i<=value; i++)
            {
                output+='<div class="col-5 border ms-3">'+
                            '<label for="dimx" class="form-label">Dimensión X del lugar ' + i + '</label>' + 
                            '<input type=number step=0.01 name="dimx' + i + '" autocomplete="off" min=0.01 class="form-control" id="dimx' + i + '" aria-describedby="xHelp" placeholder="X.XX" required>' + 
                            '<div id="xHelp" class="form-text">Formato: solo números con 2 decimales.' + '</div>' + 
                        '</div>' + 
                        '<div class="col-5 border">' + 
                            '<label for="dimy" class="form-label">Dimensión Y del lugar ' + i + '</label>' + 
                            '<input type=number step=0.01 name="dimy' + i + '" autocomplete="off" min=0.01 class="form-control" id="dimy' + i + '" aria-describedby="yHelp" placeholder="Y.YY" required>' + 
                            '<div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>' + 
                        '</div>'   
            }
            $('#dimensiones').empty().append(output);
        }
    </script>
    <script>
        function OPlaces() {
            
            var value = document.getElementById("OLugares").value
            var output='';
            console.log(value);
            for(var i=1; i<=value; i++)
            {
                output+='<div class="col-3 border ms-3">'+
                            '<label for="dimx" class="form-label">Dimensión X del lugar ' + i + '</label>' + 
                            '<input type=number step=0.01 name="ODimx' + i + '" autocomplete="off" min=0.01 class="form-control" id="ODimx' + i + '" aria-describedby="xHelp" placeholder="X.XX" required>' + 
                            '<div id="xHelp" class="form-text">Formato: solo números con 2 decimales.' + '</div>' + 
                        '</div>' + 
                        '<div class="col-3 border">' + 
                            '<label for="dimy" class="form-label">Dimensión Y del lugar ' + i + '</label>' + 
                            '<input type=number step=0.01 name="ODimy' + i + '" autocomplete="off" min=0.01 class="form-control" id="ODimy' + i + '" aria-describedby="yHelp" placeholder="Y.YY" required>' + 
                            '<div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>' + 
                        '</div>' +  
                        '<div class="col-3 border">' + 
                            '<label for="extraMeters" class="form-label">Cantidad de metros extra del lugar ' + i + '</label>' + 
                            '<input type=number step=1 name="extraMeters' + i + '" autocomplete="off" min=0 value=0 class="form-control" id="extraMeters' + i + '" aria-describedby="extraMetersHelp" placeholder="1 o 2 o 3" required>' + 
                            '<div id="extraMetersHelp" class="form-text">Cantidad entera de metros.</div>' + 
                        '</div>'   
            }
            $('#ODimensiones').empty().append(output);
        }
    </script>
@endsection
