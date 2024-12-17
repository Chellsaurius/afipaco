@extends('layouts.carcasa')

@section('title')
    <title>Inspectores</title>
@endsection

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de centros historicos donde pueden vender los artesanos</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between" >
                            <a href="{{ route('inspector.dischargedList') }}" class="btn btn-dark d-flex align-items-end">Lista de inspectores dados de baja</a>
                            <a href="{{ route('inspector.new') }}" class="btn btn-primary d-flex align-items-end">Agregar otro inspector</a>
                        </div>
                        <br>
                        <div >
                            <table id="inspectors" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
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
                                                <a class="btn btn-success" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualizarInspector{{ $inspector->id }}">
                                                    <i class="fa-solid fa-pen"></i> Actualizar datos 
                                                </a>
                                                <a class="btn btn-danger" href="{{ route('inspector.discharge', $inspector->id) }}" onclick="return confirm('¿Seguro que desea dar de baja a este inspector?')"> <i class="fa-solid fa-ban"></i> Dar de baja</a> 
                                            </td>
                                        </tr>
                                        @include('modal.updateInspector')
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @section('js')
                <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
                <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
                <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
                <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" ></script>
                <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js" ></script>
                <script>
                    $(document).ready(function() {
                        $('#inspectors').DataTable({
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
