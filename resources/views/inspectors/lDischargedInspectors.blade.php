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
            <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nombre(s)</th>
                        <th>Correo electrónico</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inspectores as $inspector)
        
                        <tr>
                            <td class="text-uppercase">{{ $inspector->name }}</td>
                            <td>{{ $inspector->email }}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('inspector.activate', $inspector->id) }}" onclick="return confirm('&iquest;Seguro que desea reactivar a este inspector? ')">Reactivar inspector</a>
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

