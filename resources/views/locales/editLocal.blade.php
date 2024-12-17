@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Editar local del comerciante</title>
@endsection

@section('content')
    <div class="container col-md-12">
        <div class="shadow-lg">
            <div class="card">
                <div class="card-header">Datos del local: {{ $local->RLocalsCategories->category_type }}</div>

                <div class="card-body">
                    <form class="row mb-4" action="{{ route('local.updateStaticLocal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="local_id" value="{{ $local->local_id }}">
                        <div class="mb-3 col-10 ">
                            <label for="ubicacion" class="form-label">Ubicación.</label>
                            <input type=text name="ubicacion" autocomplete="off" autofocus
                                value="{{ $local->local_location }}" class="form-control text-uppercase" id="ubicacion"
                                aria-describedby="ubiHelp" required>
                            @if ($local->category_id == 1 || $local->category_id == 4 ||  $local->category_id == 2)
                                <div id="ubiHelp" class="form-text">Ingresar el/los locales del comerciante.</div>
                            @else
                                <div id="ubiHelp" class="form-text">Ingresar la ruta que recorre el comerciante.</div>
                            @endif
                            @error('ubicacion')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        @if ($local->category_id != 1 && $local->category_id != 4)
                            <div class="mb-3 col-5">
                                <label for="IHour" class="form-label"> Selecciona la hora de inicio. </label>
                                <input type="time" id="IHour" name="IHour" class="form-control"
                                    value="{{ $local->local_startingHour }}" aria-describedby="iHourHelp" required>
                                <div id="iHourHelp" class="form-text">Formato: 12 horas (07:00 a.m.). </div>
                            </div>
                            <div class="mb-3 col-5">
                                <label for="FHour" class="form-label"> Selecciona la hora de finalización. </label>
                                <input type="time" id="FHour" name="FHour" class="form-control"
                                    value="{{ $local->local_endingHour }}" aria-describedby="fHourHelp" required>
                                <div id="fHourHelp" class="form-text">Formato: 12 horas (04:00 p.m.).</div>
                            </div>
                        @endif

                        @if ($local->category_id == 1)
                            <div class="mb-3 col-10 ">
                                <label for="ubicacion" class="form-label">Tianguis.</label>
                                <select name="tianguis" id="tianguis" class="form-control text-uppercase">
                                    @foreach ($tianguis as $tiangui)
                                        @if ($tiangui->tiangui_id != $local->tiangui_id)
                                            <option class="text-uppercase" value="{{ $tiangui->tiangui_id }}">
                                                {{ $tiangui->tiangui_name }} ({{ $tiangui->tiangui_dayText }}) </option>
                                        @else
                                            <option class="text-uppercase" value="{{ $tiangui->tiangui_id }}" selected>
                                                {{ $tiangui->tiangui_name }} ({{ $tiangui->tiangui_dayText }}) </option>
                                        @endif
                                    @endforeach
                                </select>
                                <div id="ubiHelp" class="form-text">Ingrese el tianguis donde vende el comerciante.</div>
                                @error('ubicacion')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        @endif 
                        @if ($local->category_id == 4)
                            <div class="mb-3 col-10 ">
                                <label for="market" class="form-label">Centro historico.</label>
                                <select name="market" id="market" class="form-control text-uppercase">
                                    @foreach ($markets as $market)
                                        @if ($market->market_id != $local->market_id)
                                            <option class="text-uppercase" value="{{ $market->market_id }}">
                                                {{ $market->market_name }}</option>
                                        @else
                                            <option class="text-uppercase" value="{{ $market->market_id }}" selected>
                                                {{ $market->market_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div id="ubiHelp" class="form-text">Ingresar el centro en el que vende el comerciante.
                                </div>
                                @error('ubicacion')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        @endif

                        @if ($local->category_id == 2 || $local->category_id == 3)
                            <div class="mb-3 col-12 border">
                                <div class="row " id="dias">
                                    <div class="@error('dia') is-invalid @enderror"></div>
                                    <label for="dias" class="form-label" aria-describedby="diasHelp">Días laborales:
                                    </label>
                                    <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                        <input type="checkbox" name="day[]" value="1" onchange="nDays(1)"
                                            data-id="1" class="form-check-input m-1" id="day1"
                                            @if (stristr($local->local_days, '1')) checked @endif>
                                        <label class="form-check-label" for="day1"> Lunes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day[]" value="2" onchange="nDays(2)"
                                            class="form-check-input m-1" id="day2"
                                            @if (stristr($local->local_days, '2')) checked @endif>
                                        <label class="form-check-label" for="day2"> Martes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day[]" value="3" onchange="nDays(3)"
                                            class="form-check-input m-1" id="day3"
                                            @if (stristr($local->local_days, '3')) checked @endif>
                                        <label class="form-check-label" for="day3"> Miércoles</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day[]" value="4" onchange="nDays(4)"
                                            class="form-check-input m-1" id="day4"
                                            @if (stristr($local->local_days, '4')) checked @endif>
                                        <label class="form-check-label" for="day4"> Jueves</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day[]" value="5" onchange="nDays(5)"
                                            class="form-check-input m-1" id="day5"
                                            @if (stristr($local->local_days, '5')) checked @endif>
                                        <label class="form-check-label" for="day5"> Viernes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day[]" value="6" onchange="nDays(6)"
                                            class="form-check-input m-1" id="day6"
                                            @if (stristr($local->local_days, '6')) checked @endif>
                                        <label class="form-check-label" for="day6"> Sábado</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day[]" value="7" onchange="nDays(7)"
                                            class="form-check-input m-1" id="day7"
                                            @if (stristr($local->local_days, '7')) {
                                                checked
                                            } @endif>
                                        <label class="form-check-label" for="day7"> Domingo</label>
                                    </div>
                                    @error('dia')
                                        <span class="invalid-feedback col-12 p-3"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <div id="diasHelp" class="form-text">Ingrese los días que laborará el comerciante.
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mb-3 col-12 border form-control ">  {{-- parte del código para los giros --}}
                            <div class="row " >
                                <div class="@error('merchant_activity') is-invalid @enderror"></div>
                                <label for="bussinnes" class="form-label ">Giro(s)</label>
                                <div class="d-flex justify-content-left col-2 border align-items-center">
                                    <input type="checkbox" name="giro[]" value="ropa usada" class="form-check-input m-1" id="ropa usada"
                                    @if (stristr($local->local_activity, 'ropa usad')) {
                                            checked
                                        } 
                                    @endif>
                                    <label class="form-check-label" for="ropa usada"> Ropa usada</label>
                                </div>
                                <div class="d-flex justify-content-left border col-2 align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="herramientas" class="form-check-input m-1" id="herramientas"
                                    @if (stristr($local->local_activity, 'herramientas')) {
                                            checked
                                        } 
                                    @endif>
                                    <label class="form-check-label" for="herramientas">Herramientas</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="comida" class="form-check-input m-1" id="comida"
                                    @if (stristr($local->local_activity, 'comida')) {
                                            checked
                                        } 
                                    @endif>
                                    <label class="form-check-label" for="comida">Comida</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="bisutería" class="form-check-input m-1" id="bisuteria"
                                    @if (stristr($local->local_activity, 'bisuteria')) {
                                            checked
                                        } 
                                    @endif>
                                    <label class="form-check-label" for="bisuteria">Bisutería</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="juguetes" class="form-check-input m-1" id="juguetes"
                                        @if (stristr($local->local_activity, 'juguetes')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="juguetes">Juguetes</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="plasticos" 
                                        class="form-check-input m-1" id="plasticos"
                                        @if (stristr($local->local_activity, 'plasticos')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="plasticos">Plasticos</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="tacos" class="form-check-input m-1" id="tacos"
                                        @if (stristr($local->local_activity, 'tacos')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="tacos">Tacos</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="gorditas" class="form-check-input m-1" id="gorditas"
                                        @if (stristr($local->local_activity, 'gorditas')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="gorditas">Gorditas</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="dulces" class="form-check-input m-1" id="dulces"
                                        @if (stristr($local->local_activity, 'dulces')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="dulces">Dulces</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="fruta" class="form-check-input m-1" id="fruta"
                                        @if (stristr($local->local_activity, 'fruta')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="fruta">Frutas</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="verdura" class="form-check-input m-1" id="verdura"
                                        @if (stristr($local->local_activity, 'verdura')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="verdura">Verduras</label>
                                </div>
                                <div class="d-flex justify-content-left  col-2 border align-items-center p-3">
                                    <input type="checkbox" name="giro[]" value="artesanías" class="form-check-input m-1" id="artesanias"
                                        @if (stristr($local->local_activity, 'artesanías')) {
                                                checked
                                            } 
                                        @endif>
                                    <label class="form-check-label" for="artesanias">Artesanías</label>
                                </div>
                                
                                <div class="mb-3 col-12 p-3">
                                    <input type="checkbox" value="otros" class="form-check-input m-1 @error('otros') is-invalid @enderror" id="otros"  >
                                    <label class="form-label" for="otros">Otros</label>
                                    <input type="text" name="otrosg" class="form-control text-uppercase" id="otrosg" aria-describedby="giroHelp" disabled
                                        @if ( $local->local_activity)
                                            value="{{ trim($local->local_activity, ',') }}" 
                                        @endif>
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

                        <div class="col-12 ml-4">
                            <br>
                            <div class="mb-3 form-check col-7 ">
                                <input type="checkbox" class="form-check-input" id="finalCheck" required>
                                <label class="form-check-label" for="finalCheck">Los datos del local son correctos
                                </label>
                            </div>
                        </div>
                        <div class="col-6 ml-4">
                            <button type="submit" class="btn btn-primary col-6">Guardar información del local</button>
                        </div>
                    </form>
                    <hr style="border: 10px solid rgb(105, 185, 105); border-radius: 5px;">
                    <br>
                    @if ($local->category_id == 1 || $local->category_id == 4)
                        <div class="col-8 mb-3 p-3 mb-5">
                            <label for="lugares" class="form-label">Lugares: <b> {{ $local->local_places }} </b>
                            </label> &nbsp; &nbsp; &nbsp;
                            <label>Área total de los lugares: <b> {{ $local->local_area }}m </b></label>
                            <br>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addTPlace">
                                Añadir un nuevo lugar
                            </button>
                        </div>
                        @include('locales/modal/addTLugares')
                        <table id="lugares" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Dimensión en X</th>
                                    <th>Dimensión en Y</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($local->RLocalPlaces as $lugar)
                                    <tr>
                                        <td>{{ $lugar->place_dimx }}</td>
                                        <td>{{ $lugar->place_dimy }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#editPlace{{ $lugar->place_id }}">
                                                Actualizar datos
                                            </button>

                                            <a class="btn btn-danger"
                                                href="{{ route('local.cancelTSpace', $lugar->place_id) }}"
                                                onclick="return confirm('¿Seguro que desea dar de baja este lugar?')">
                                                Dar de baja al lugar</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endif
                    @if ($local->category_id == 2 || $local->category_id == 3)
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">Módulo para editar medidas</h5>
                                <p class="card-text">Área total: <b> {{ $local->local_area }}m </b></p>
                            </div>
                        </div>
                        <br>
                        
                        <table id="lugares" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Dimensión en X</th>
                                    <th>Dimensión en Y</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $local->local_dimx }}</td>
                                    <td>{{ $local->local_dimy }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#editLocalDimentions{{ $local->local_id }}">
                                            Actualizar datos
                                        </button>
                                    </td>
                                </tr>
                                @include('locales.modal.editLocalDimentions')
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>

    @section('js')
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#lugares').DataTable({
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Último",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                });
            });
        </script>
        <script>
            $('#lugares').on('change', function() {
                var value = $(this).val();
                var output = '';
                for (var i = 1; i <= value; i++) {
                    output += '<div class="col-5 border">' +
                        '<label for="dimx" class="form-label">Dimensión X del lugar ' + i + '</label>' +
                        '<input type=number step=0.01 name="dimx' + i +
                        '" autocomplete="off" autofocus="on" min=0.01 class="form-control" id="dimx" aria-describedby="xHelp" placeholder="X.XX" required>' +
                        '<div id="xHelp" class="form-text">Formato: solo números con 2 decimales.' + '</div>' +
                        '</div>' +
                        '<div class="col-5 border">' +
                        '<label for="dimy" class="form-label">Dimensión Y del lugar ' + i + '</label>' +
                        '<input type=number step=0.01 name="dimy' + i +
                        '" autocomplete="off" autofocus="off" min=0.01 class="form-control" id="dimy" aria-describedby="yHelp" placeholder="Y.YY" required>' +
                        '<div id="yHelp" class="form-text">Formato: solo números con 2 decimales.</div>' +
                        '</div>'
                }
                $('#dimensiones').empty().append(output);
            });
        </script>
    @endsection
</div>
@endsection
