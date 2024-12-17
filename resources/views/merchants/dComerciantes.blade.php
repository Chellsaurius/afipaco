@extends('layouts.carcasa')

@section('css')
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Inhabilitar comerciante</title>
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
                    <th>Nombres</th>
                    <th>CURP</th>
                    <th>Domicilio</th>
                    <th>Teléfono 1</th>
                    <th>Teléfono 2</th>
                    <th>Giro(s)</th>
                    <th>Días laborados </th>
                    <th>Apercibimientos</th>
                    <th>Categoría</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($merchants as $merchant)

                    <tr>
                        <td class="text-uppercase">{{ $merchant->merchant_names }}</td>
                        <td class="text-uppercase">{{ $merchant->merchant_curp }}</td>
                        <td class="text-uppercase">{{ $merchant->merchant_address }}</td>
                        <td>{{ $merchant->merchant_phone1 }}</td>
                        <td>{{ $merchant->merchant_phone2 }}</td>
                        <td>{{ $merchant->merchant_activity }}</td>
                        <td>{{ $merchant->merchant_days }}</td>
                        <td>{{ $merchant->merchant_warnings }}</td>
                        <td></td>
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