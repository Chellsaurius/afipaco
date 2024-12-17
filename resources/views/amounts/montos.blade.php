@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Monto fiscal</title>
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
                    <div class="card-header">Monto por metro cuadrado del año fiscal.</div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between" >
                            <h2 class="text-start align-items-start"></h2>
                            <a href="{{ route('nmontos') }}" class="btn btn-primary d-flex align-items-end">Registrar un nuevo costo</a>
                        </div>
                        
                        <br>
                        <div class="col-12">
                            <table id="monto" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Monto por m^2</th>
                                        <th>Año fiscal</th>
                                        <th>Disposición administrativa</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($montos as $monto)
                                        <tr>
                                            <td>${{ number_format($monto->amount_cost, 2) }}</td>
                                            <td>{{ $monto->amount_year }}</td>
                                            <td class="text-uppercase">{{ $monto->RAmountRegulation->regulation_name }}</td>
                                            <td>
                                                @if ($monto->amount_status == 1)
                                                    <a class="btn btn-danger" href="{{ route('amount.disable', $monto->amount_id) }}" 
                                                        onclick="return confirm('¿Seguro que desea desactivar este monto?')"> 
                                                        Deshabilitar
                                                    </a> 
                                                @else
                                                    <a class="btn btn-success" href="{{ route('amount.enable', $monto->amount_id) }}" 
                                                        onclick="return confirm('¿Seguro que desea activar este pago?')"> 
                                                        Activar
                                                    </a> 
                                                @endif
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
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js" ></script>
        <script>
            $(document).ready(function() {
                $('#monto').DataTable({
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
