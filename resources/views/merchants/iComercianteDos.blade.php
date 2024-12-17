@extends('layouts.carcasa')

@section('css')
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Información del comerciante</title>
@endsection

@section('content')
    
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-sucess">
                {{ session()->get('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div> 
        @endif
        <br>
        
        <div class="border shadow-lg p-3 mb-5 bg-body rounded">
            <div class="col-md-12">
                
                <div class="d-flex justify-content-between row ">
                    <div class="mb-3 col-6 border">
                        <label for="curp" class="form-label">CURP</label>
                        <input type="text" id="curp" name="curp" class="form-control" value="{{ $merchant->merchant_curp }}" aria-describedby="folioHelp" readonly>
                        <div id="curpHelp" class="form-text">Clave única de registro de población. </div>
                        
                    </div>
                    <div class="mb-3 col-12 border">
                        <label for="name" class="form-label">Nombres</label>
                        <input type="text" name="name" class="form-control text-uppercase" value="{{ $merchant->merchant_names}}" id="name" aria-describedby="nameHelp" readonly>
                        <div id="nameHelp" class="form-text">Nombres del ciudadano. </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    
                    <div class="mb-3 col-12 border">
                        <label for="business" class="form-label">Giro</label>
                        <input type="text" name="business" class="form-control" value="{{ trim($merchant->merchant_activity, ',') }}" id="business" aria-describedby="businessHelp" readonly >
                        <div id="businessHelp" class="form-text">Giro(s).</div>
                        @error('business')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                                            
                    <div class="mb-3 col-12 border">
                        <label for="days" class="form-label">Dias que labora el comerciante</label>
                        <input type="text" name="days" class="form-control" value="{{ $merchant->merchant_days }}" id="days" aria-describedby="daysHelp" readonly hidden>
                        <input type="text"  class="form-control" 
                            @for ($i=1; $i<=strlen($merchant->merchant_days); $i++)
                                
                                {{ $merchant->merchant_days = str_replace("1", "LUNES", $merchant->merchant_days) }}
                                {{ $merchant->merchant_days = str_replace("2", "MARTES", $merchant->merchant_days) }}
                                {{ $merchant->merchant_days = str_replace("3", "MIÉRCOLES", $merchant->merchant_days) }}
                                {{ $merchant->merchant_days = str_replace("4", "JUEVES", $merchant->merchant_days) }}
                                {{ $merchant->merchant_days = str_replace("5", "VIERNES", $merchant->merchant_days) }}
                                {{ $merchant->merchant_days = str_replace("6", "SÁBADO", $merchant->merchant_days) }}
                                {{ $merchant->merchant_days = str_replace("7", "DOMINGO", $merchant->merchant_days) }}
                            @endfor
                        value="{{ trim($merchant->merchant_days, ',') }}"   readonly>
                        <div id="daysHelp" class="form-text">Dias que labora el comerciante.</div>
                        @error('days')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    
                    <table id="locales" class="table table-striped dt-responsive nowrap table-bordered col-12" style="width:100%">
                        <thead>
                            <tr>
                                <th>Ubicación o recorrido</th>
                                <th>Hora de inicio</th>
                                <th>Hora de finalización</th>
                                <th>Tianguis</th>
                                <th>Mostrar pagos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locales as $local)
                                <tr>
                                    <td class="text-uppercase">{{ $local->local_location }}</td>
                                    <td>{{ $local->local_startingHour }}</td>
                                    <td>{{ $local->local_endingHour }}</td>
                                    <td class="text-uppercase">{{ $local->nombre_tianguis }}</td>
                                    <td >
                                        <form action="{{ route('ajax.pagos', $local->local_id) }}" method="post" id="form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $local->local_id }}" id="hidden">
                                            
                                            <button type="button" class="btn btn-primary" onclick="pagos({{ $local->local_id }})" 
                                                value="{{ $local->local_id }}" id="local{{ $local->local_id }}"
                                                data-bs-toggle="modal" data-bs-target="#mostrarPagosModal{{ $local->local_id }}" >
                                                Pagos del local {{ $local->local_id }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <script>
                                    function pagos(id) {
                                        var id = id;
                                        var url = '/verPagosComerciante/' + id;
                                        //console.log(id, url, token)
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({
                                            url: url,
                                            method: 'POST',
                                            dataType: 'json',
                                            data:{
                                                "_token": "{{ csrf_token() }}",
                                                id: id
                                            }
                                        }).done(function(respuesta){
                                            console.log(respuesta.length)
                                            var element = [];
                                            for (let index = 0; index < respuesta.length; index++) {
                                                element = element + '<div class="border col-4">' + respuesta[index].folio + '</div> <div class="border col-4">' + respuesta[index].fecha_inicio + '</div> <div class="border col-4">' + respuesta[index].fecha_final + '</div>';
                                                
                                            }
                                            var todo =  '<div class="border col-4" >Folio</div> <div class="border col-4" >Inicio de contrato</div> <div class="border col-4" >Fin de contrato</div>' + element;
                                                        
                                            $('#mostrar').html(todo);
                                            
                                        });
                                        // Update the modal's content.
                                        
                                        
                                    }
                                </script>
                                @include('modal.lPayments')
                            @endforeach
                        </tbody>
                    </table>
                    
                    <br>
                    <br>
                    <br>
                    
                    <form action="{{ route('warnings.generate') }}" method="POST" >
                        @csrf
                        <input type="hidden" name="merchant_id" value="{{ $merchant->merchant_id }}">
                        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
    
                        <div class="mb-3 col-12 border col align-self-center">
                            <label for="comentario" class="form-label"> Comentario del apercibimiento. </label>
                            <input type="text" id="comentario" name="comentario" class="form-control text-uppercase" autocomplete="off" aria-describedby="comentarioHelp" >
                            <div id="comentarioHelp" class="form-text">Descripción del apercibimiento. </div>
                        </div>
                        <div class="mb-3 col-12 ">
                            <div class="mb-3 ml-10 form-check ">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                <label class="form-check-label" for="exampleCheck1">Quiero generar un apercibimiento</label>
                            </div>
                            <button type="submit" class="btn btn-primary col-5 ">Generar apercibimiento</button> 

                        </div>
                    
                    </form>
                </div>
            </div>
        </div>  
        @section('js')
            <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
            <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
            <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" ></script>
            <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js" ></script>
            <script>
                $(document).ready(function() {
                    $('#locales').DataTable({
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

        @endsection
    </div>
@endsection
