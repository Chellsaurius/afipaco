@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Lista de tianguis</title>
@endsection

@section('content')

<div class="container">
    <div class="shadow-lg">
        <div class="card">
            <div class="card-header">Lista de tianguis</div>

            <div class="card-body">
                <div class="d-flex justify-content-end" >
                    <a href="{{ route('nTianguis') }}" class="btn btn-primary d-flex align-items-end">Registra otro tianguis aqui</a>
                </div>
                
                <br>
                <div>
                    <table id="tianguis" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Día</th>
                                <th>Hora de inicio</th>
                                <th>Hora de finalización</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tianguis as $tiangui)
                                <tr>
                                    <td class="text-uppercase">{{ $tiangui->tiangui_name }}</td>
                                    <td class="text-uppercase">{{ $tiangui->tiangui_dayText }}</td>
                                    <td>{{ date_format(date_create($tiangui->tiangui_startingHour), 'h:i A') }}</td>
                                    <td>{{ date_format(date_create($tiangui->tiangui_endingHour), 'h:i A') }}</td>
                                    <td>
                                        <a class="btn btn-success" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualizarTianguis{{ $tiangui->tiangui_id }}">
                                            <i class="fa-solid fa-pen"></i> Actualizar datos 
                                        </a>
        
                                        <a class="btn btn-danger" href="{{ route('tianguis.deactivate', $tiangui->tiangui_id) }}" 
                                            onclick="return confirm('¿Seguro que desea dar de baja este tianguis?')"> 
                                            <i class="fa-solid fa-trash-can"></i>  Dar de baja </a> 
                                    </td>
                                </tr>
                            
                                @include('tianguis.modal.updateTianguis')
                            @endforeach
        
                            
                        </tbody>
                    </table>
                </div>
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
                $('#tianguis').DataTable({
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
