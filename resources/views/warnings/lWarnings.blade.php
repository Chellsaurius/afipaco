@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Lista de apercibimientos</title>
@endsection

@section('content')    
    <div class="container">
        <div class=" shadow-lg p-3 mb-5 bg-body rounded">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif


            <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombres </th>
                        <th>CURP</th>
                        <th>Fecha del apercibimiento</th>
                        <th>Comentario</th>
                        <th>Inspector</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apercibimientos as $apercibimiento)
        
                        <tr>
                            <td class="text-uppercase">{{ $apercibimiento->comerciantes->merchant_names }}</td>
                            <td>{{ $apercibimiento->comerciantes->merchant_curp ?? 'no tiene CURP' }}</td>
                            <td>{{ $apercibimiento->created_at }}</td>
                            <td class="text-uppercase">{{ $apercibimiento->comentario }}</td>
                            <td class="text-uppercase">{{ $apercibimiento->merchant_warnings->name }}</td>
                            <td>
                            <a class="btn btn-primary" href="{{ route('warning.remove', $apercibimiento->id_apercibimiento) }}"> 
                                    <i class="fa-solid fa-check"></i> Quitar apercibimiento</a> 
                                
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