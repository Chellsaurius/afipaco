@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    <style>
        #horas {
            word-break: break-word;
            vertical-align: top;
            white-space: normal !important;
        }
    </style>
@endsection

@section('title')
    <title>Locales del comerciante</title>
@endsection

@section('content')    
    @if (session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="backgroundColor: '#e3342f', color: '#fff', '&:hover': { backgroundColor: '#cc1f1a'},">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-uppercase">
                        Locales  del comerciante: {{ $merchant->merchant_names }}
                    </div>
                    <br>
                    <div class="px-3 mb-3">
                        <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Ubicación</th>

                                    <th>Horario laboral</th>
                                    
                                    <th>Categoría</th>
                                    
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($merchant->RMerchantRecords as $record)
                                    <tr>
                                        <td class="text-uppercase" >{{ $record->RRecordsLocals->local_location }}</td>
                                        <td id="horas">
                                            De: {{ date_format(date_create($record->RRecordsLocals->local_startingHour), 'h:i A')  ?? '' }} a: {{ date_format(date_create($record->RRecordsLocals->local_endingHour), 'h:i A')  ?? '' }}
                                        </td>
                                        <td>{{ $record->RRecordsLocals->RLocalsCategories->category_type }}</td>
                                        <td>
                                            @if ($record->RRecordsLocals->category_id == 4) 
                                                {{-- para los Ocasionales --}}
                                                <button type="button"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pagarModalOcasional{{ $record->RRecordsLocals->local_id }}">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i> Pagar local O
                                                </button>
                                                @include('payments.modal.ocationalPayment')
                                            @endif
                                            @if($record->RRecordsLocals->category_id == 1)
                                                {{-- para  los Tianguistas --}}
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pagarModal{{ $record->RRecordsLocals->local_id }}">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i> Pagar local T
                                                </a>
                                                @include('payments.modal.newPayment')
                                            @endif 
                                            @if($record->RRecordsLocals->category_id == 2 || $record->RRecordsLocals->category_id == 3)
                                                {{-- para  los Semifijos o Ambulantes --}}
                                                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pagarModalOtros{{ $record->RRecordsLocals->local_id }}">
                                                    <i class="fa-solid fa-file-invoice-dollar"></i> Pagar local N
                                                </a>
                                                @include('payments.modal.newPaymentO')
                                            @endif 
                                            
                                            <a class="btn btn-success" href="{{ route('local.localDetails', $record->RRecordsLocals->local_id ) }}">
                                                Editar
                                            </a>
                                            <a class="btn btn-danger" href="{{ route('local.cancel', $record->RRecordsLocals->local_id ) }}" 
                                                onclick="return confirm('¿Desea dar de baja este local?')"> Dar de baja el local
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            @section('js')
            
                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
                <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
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
    </div>
@endsection