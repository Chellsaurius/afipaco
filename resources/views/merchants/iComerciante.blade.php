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
        @if (Auth::user()->user_rol == 1)
            <div class="col-12 d-flex justify-content-end align-items-end">
                <a href="{{ route('payment.locals', $merchant->merchant_curp) }}" class="btn btn-primary col-2">Generar pago</a>
            </div>
            <br>
        @endif
        
        @if ($merchant->merchant_status >= 2)
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">¡CUIDADO!</h4>
                <p>EL COMERCIANTE ESTÁ DADO DE BAJA.</p>
                <hr>
                <p class="mb-0">PROCEDA A INFORMAR A SUS COMPAÑEROS Y A SEGUIR LOS PROTOCOLOS ADECUADOS PARA LA SITUACIÓN.</p>
            </div>
        @endif

        <div class="d-flex justify-content-between row ">
            <div class="mb-3 col-12 border">
                <label for="curp" class="form-label">CURP</label>
                <input type="text" id="curp" name="curp" class="form-control text-uppercase" value="{{ $merchant->merchant_curp }}" aria-describedby="folioHelp" readonly>
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
                <input type="text" name="business" class="form-control" value="{{ trim($locales->first()->local_activity, ',') }}" id="business" aria-describedby="businessHelp" readonly >
                <div id="businessHelp" class="form-text">Lo que vende el comerciante.</div>
                @error('business')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            
            <div class="mb-3 col-12 border">
                <label for="days" class="form-label">Dias que labora el comerciante</label>
                <input type="hidden" name="days" class="form-control" value="{{ $locales->first()->local_daysText }}" id="days" aria-describedby="daysHelp" readonly>
                <input type="text" name="days" class="form-control text-uppercase" value="{{ $locales->first()->local_daysText }}" aria-describedby="daysHelp" readonly>
                <div id="daysHelp" class="form-text">Dias que labora el comerciante.</div>
                @error('days')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <hr>
        <table id="pagos" class="table table-striped dt-responsive display nowrap table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Ubicación/Recorrido</th>
                    <th>Horario laboral</th>
                    <th>Dimensiones</th>
                    <th>Tianguis</th>
                    <th>Centro historico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locales as $local)
                    <tr>
                        <td class="text-uppercase">{{ $local->local_location }}</td>
                        <td>{{ date_format(date_create($local->local_startingHour), 'h:i A') }} a {{ date_format(date_create($local->local_endingHour), 'h:i A' ) }}</td>
                        <td>{{ $local->local_dimx }} x {{ $local->local_dimy }}m</td>
                        <td class="text-uppercase">{{ $local->tiangui_name ?? '' }}</td>
                        <td class="text-uppercase">{{ $local->market_name ?? '' }}</td>
                        <td>
                            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verPago{{ $local->local_id }}" onclick="ultimoPago({{ $local->local_id }})">
                                Ver pago del local
                            </a>
                        </td>
                    </tr>   
                    <script>
                        function ultimoPago(id) {
                            var id = id;
                            var url = '/conseguirUltimoPago/' + id;
                            var token = document.getElementById('token').value;
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            console.log(id, url, token)
                            $.ajax({
                                url: url,
                                method: 'POST',
                                dataType: 'json',
                                data:{
                                    "_token": "{{ csrf_token() }}",
                                    id: id
                                }
                            }).done(function(respuesta){
                                console.log(respuesta)
                                if($.isEmptyObject(respuesta))
                                {
                                    console.log('nop')
                                    $('#folio' + id).val( '(No tiene pagos anteriores)' );
                                    $("#finalDate" + id).val('(No tiene pagos anteriores)');
                                }else{
                                    
                                    const d = new Date(respuesta.fecha_final);
                                    d.setDate(d.getDate() + 1);
                                    var fecha = respuesta.fecha_final.toString();
                                    $("#folio" + id).val(respuesta.folio);
                                    $("#finalDate" + id).val(fecha);
                                    
                                }
                                
                            });
                            
                        }
                    </script>
                    @include('merchants.modal.lastPayment')
                @endforeach
            </tbody>
        </table>
        
        <form action="{{ route('warnings.generate') }}" method="POST" >
            @csrf
            <input type="hidden" name="merchant_id" value="{{ $merchant->merchant_id }}">
            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
            <div class="mb-3 col-12 border col align-self-center">
                <label for="comentario" class="form-label"> Razón del apercibimiento </label>
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
        
    @section('js')
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js" ></script>
        <script>
            $(document).ready(function() {
                $('#pagos').DataTable({
                    scrollX: true,
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
    
@endsection
    