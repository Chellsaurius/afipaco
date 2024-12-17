@extends('layouts.carcasa')

@section('css')
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Lista de locales</title>
@endsection

@section('content')    
    <div class="container">
        <div class=" shadow-lg p-3 mb-5 bg-body rounded">
            @if(session()->has('message'))
                <div class="alert alert-danger">
                    {{ session()->get('message') }}
                </div>
            @endif
            <br>
            <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>curp</th>
                        <th>Ubicación o recorrido</th>
                        <th>Horario laboral</th>
                        <th>Tianguis</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locales as $local)
                        
                        <tr>
                            <td class="text-uppercase">{{ $local->merchant_names }}</td>
                            <td>{{ $local->merchant_curp }}</td>
                            <td class="text-uppercase">{{ $local->local_location }}</td>
                            <td>De: {{ date_format(date_create($local->local_startingHour), 'h:i A') }} a: {{ date_format(date_create($local->local_endingHour), 'h:i A') }}</td>
                            <td class="text-uppercase">{{ $local->nombre_tianguis }}</td>
                            
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