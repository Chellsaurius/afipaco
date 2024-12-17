@extends('layouts.carcasa')

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de centros historicos donde pueden vender los artesanos</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end" >
                            <a href="{{ route('market.new') }}" class="btn btn-primary d-flex align-items-end">Registra otro lugar</a>
                        </div>
                        <br>
                        <div >
                            <table id="markets" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Hora de inicio</th>
                                        <th>Hora de finalización</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($markets as $market)
                                        <tr>
                                            <td class="text-uppercase">{{ $market->market_name }}</td>
                                            <td>{{ $market->market_startingHour }}</td>
                                            <td>{{ $market->market_endingHour }}</td>
                                            <td>
                                                <a class="btn btn-success" class="btn btn-primary" data-bs-toggle="modal" 
                                                    data-bs-target="#actualizarLugar{{ $market->market_id }}">
                                                    Actualizar datos 
                                                </a>
                                                @include('markets.modal.editMarket')
                                                <form action="{{ route('market.disable', $market->market_id) }}" method="post">
                                                    <button type="submit"class="btn btn-danger" 
                                                        onclick="return confirm('¿Seguro que desea dar de baja este lugar?')">Deshabilitar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            $('#markets').DataTable({
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
