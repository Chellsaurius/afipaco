@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Lista de comerciantes</title>
@endsection

@section('content')    
    <div class="container">
        <div class=" shadow-lg p-3 mb-5 bg-body rounded">
            @if(session()->has('message'))
                <div class="alert alert-danger">
                    {{ session()->get('message') }}
                </div>
            @endif
            
            <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>CURP</th>
                        <th>Domicilio</th>
                        <th>Teléfono 1</th>
                        <th>Teléfono 2</th>
                        <th>Apercibimientos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($merchants as $merchant)

                        <tr @if ($merchant['merchant_status'] == 2)
                                class="table-danger"
                            @endif >

                            <td class="text-uppercase">{{ $merchant['merchant_names'] }}</td>
                            <td class="text-uppercase">{{ $merchant['merchant_curp'] }}</td>
                            <td class="text-uppercase">{{ $merchant['merchant_address'] }}</td>
                            <td>{{ $merchant['merchant_phone1'] ?? 'No registrado' }}</td>
                            <td>{{ $merchant['merchant_phone2'] ?? 'No registrado' }}</td>
                            <td>{{ $merchant->merchant_warnings }}</td>
                            <td>
                                @if ($merchant->merchant_status == 2)
                                    <a class="btn btn-warning" href="{{ route('warnings.especificList', $merchant['merchant_curp']) }}">
                                        <i class="fa-solid fa-circle-exclamation"></i> Ver apercibimientos </a>
                                    <a class="btn btn-success" href="{{ route('merchant.reactivate', $merchant['merchant_curp']) }}">
                                        <i class="fa-solid fa-user-check"></i> Activar comerciante</a>
                                    <a class="btn btn-primary" href="{{ route('payment.locals', $merchant['merchant_curp'] ) }}"> 
                                        <i class="fa-solid fa-file-invoice-dollar"></i> Refrendos</a>
                                @else
                                    <a class="btn btn-primary" href="{{ route('merchant.registerLocal', $merchant['merchant_curp']) }}"> <i class="fa-solid fa-building-user"></i> Registrar un local</a>
                                    
                                    <a class="btn btn-primary" href="{{ route('payment.locals', $merchant['merchant_curp'] ) }}"> <i class="fa-solid fa-file-invoice-dollar"></i> Refrendos</a>
                                    
                                    <a class="btn btn-primary" href="{{ route('merchant.dwnlqr', $merchant['merchant_id'] ) }}" target="_blank"> <i class="fa-solid fa-qrcode"></i> Descargar QR</a>

                                    <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateMerchant{{ $merchant['merchant_curp'] }}"> 
                                        <i class="fa-solid fa-pen"></i> Actualizar datos
                                    </a>
                                    
                                    <a class="btn btn-danger" href="{{ route('merchant.cancel', $merchant['merchant_curp'] ) }}"> <i class="fa-solid fa-ban"></i> Dar de baja al comerciante</a>
                                
                                @endif
                            </td>
                        </tr>
                        @include('merchants/modal/updateMerchant')
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

