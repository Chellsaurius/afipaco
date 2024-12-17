@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Pagos diarios</title>
@endsection
@section('content')
    <div class="content">
        <div class="row justify-content-center shadow- bg-body rounded">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reporte</div>
                    
                    <div class="card-body">
                        <table id="pagosT" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%; text-transform:uppercase">
                            <thead>
                                <tr>
                                    @if ($cat == 1)
                                        <th>Folio</th>
                                        <th>Nombre</th>
                                        <th>Fecha y hora del pago</th>
                                        <th>Tianguis (día)</th>
                                        <th>Giro(s)</th>
                                        <th>Vigencia</th>
                                        <th>Medidas</th>
                                        <th>Cantidad</th>
                                        <th>Lugar</th>
                                    @else
                                        <th>Nombre</th>
                                        <th>Ubicación del negocio</th>
                                        <th>Colonia del comerciante</th>
                                        <th>Giro(s)</th>
                                        <th>Medidas</th>
                                        <th>Días que labora</th>
                                        <th>Vigencia</th>
                                        <th>Folio</th>
                                        <th>Fecha y hora del pago</th>
                                        <th>Monto</th>
                                    @endif
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if ($cat == 1)
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_folio }}</td>
                                            <td>{{ $payment->payment_name }}</td>
                                            <td>{{ ($payment->created_at) }} </td>
                                            <td>{{ $payment->payment_localVenue }} ({{$payment->payment_daysText }})</td>
                                            <td>{{ trim($payment->payment_activities, ',') }}</td>
                                            <td>Del: {{ date('d-m-Y', strtotime($payment->payment_startingDate ?? '')) }} al {{ date('d-m-Y', strtotime($payment->payment_endingDate ?? '')) }}</td>
                                            <td>{{ $payment->payment_dimentions }} </td>
                                            <td>$ {{ number_format($payment->payment_amount, 2) }}</td>
                                            <td>{{ $payment->payment_place }}</td>
                                        </tr>
                                        
                                        
                                    @endforeach
                                @else
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_name }}</td>                                
                                            <td>{{ $payment->payment_place }}</td>
                                            <td>{{ $payment->RPaymentsMerchant->merchant_address }}</td> 
                                            <td>{{ trim($payment->payment_activities, ',') }}</td>
                                            <td>{{ $payment->payment_dimentions }} @if ($cat == 4)
                                                de 2x3 mts 
                                            @endif </td>
                                            <td>{{ $payment->payment_daysText }}</td>
                                            <td>Del: {{ date_format(date_create($payment->payment_startingDate), 'd-m-Y') }} al: {{ date_format(date_create($payment->payment_endingDate), 'd-m-Y') }}</td>
                                            <td>{{ $payment->payment_folio }}</td>
                                            <td>{{ date_format(date_create($payment->created_at), 'd-m-Y h:i A') }} </td>
                                            <td>$ {{ number_format($payment->payment_amount, 2) }}</td>
                                        </tr>
                                        
                                    @endforeach
                                    
                                @endif
                                
                    
                                
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
                $('#pagosT').DataTable({
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