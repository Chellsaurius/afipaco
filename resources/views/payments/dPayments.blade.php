@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Locales del comerciante</title>
@endsection

@section('content')    
    <div class="container">
        <div class=" shadow-lg p-3 mb-5 bg-body rounded">
            @if(session()->has('message'))
                <div class="alert alert-danger">
                    {{ session()->get('message') }}
                </div>
            @endif
            
    
            <div class="d-flex justify-content-between">
                <h2 class="text-start align-items-start">Locales  del comerciante con CURP: {{ $curp }}</h2>
            </div>
            <br>
            <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Ubicación/Recorrido</th>
                        
                        <th>Horario laboral</th>

                        <th>Tianguis</th>
                        
                        <th>Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locales as $local)
                        <tr>
                            <td class="text-uppercase">{{ $local->local_location ?? '' }}</td>
                            <td>De: {{ date_format(date_create($local->local_startingHour), 'h:i A')  ?? '' }} a {{ date_format(date_create($local->local_endingHour), 'h:i A')  ?? '' }}</td>
                            <td>{{ $local->nombre_tianguis ?? '' }} ({{ $local->tiangui_dayText }})</td>
                            
                            <td>
                                @if ($local->category_id == 1)
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pagarModal{{ $local->local_id }}" onclick="ultimoPago({{ $local->local_id }})">
                                        <i class="fa-solid fa-file-invoice-dollar"></i> Pagar local
                                    </a>
                                    @include('payments.modal.newPayment')
                                @endif
                                @if ($local->category_id <> 1 && $local->category_id <> 4)
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pagarModalOtros{{ $local->local_id ?? '' }}" onclick="ultimoPago({{ $local->local_id }})">
                                        <i class="fa-solid fa-file-invoice-dollar"></i> Pagar local
                                    </a>
                                    @include('payments.modal.newPaymentO')
                                @endif
                                @if ($local->category_id == 4)
                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pagarModalOcasionales{{ $local->local_id ?? '' }}" onclick="ultimoPago({{ $local->local_id }})">
                                        <i class="fa-solid fa-file-invoice-dollar"></i> Pagar local
                                    </a>
                                    @include('payments.modal.ocationalPayment')
                                @endif
                                
                                <a class="btn btn-success" href="{{ route('local.localDetails', $local->local_id ) }}">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <a class="btn btn-danger" href="{{ route('local.cancel', $local->local_id ) }}" onclick="return confirm('¿Desea dar de baja este local?')">
                                    <i class="fa-solid fa-ban"></i> Dar de baja el local
                                </a>
                            </td>
                        </tr>
                        
                        
                        
                    @endforeach
                
                </tbody>
            </table>
        </div>
        
        @section('js')
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js" ></script>
        <script>
            $(document).ready(function() {
                $('#montos').DataTable({
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