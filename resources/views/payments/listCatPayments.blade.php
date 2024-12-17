@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    <style>
        #montos{ 
            text-transform: uppercase;
        }
    </style>
@endsection

@section('title')
    <title>Lista de pagos por categoria</title>
@endsection

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de pagos por categoria</div>

                    <div class="card-body">
                        <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Nombres </th>
                                    <th>Categoría</th>
                                    <th>Inicio de contrato</th>
                                    <th>Fin de contrato</th>
                                    <th>Días laborados</th>
                                    <th>Cantidad cobrada</th>
                                    <td>Ubicación o recorrido</td>
                                    <th>Medidas</th>
                                    <th>Giro(s)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    
                                    <tr>
                                        <td>{{ $payment->payment_folio ?? 'algo' }}</td>
                                        <td class="text-uppercase">{{ $payment->payment_name ?? 'algo' }}</td>
                                        <td>{{ $payment->payment_category ?? 'algo' }}</td>
                                        <td>{{ date_format(date_create($payment->payment_startingDate), 'd/m/Y') }}</td>
                                        <td>{{ date_format(date_create($payment->payment_endingDate), 'd/m/Y') }}</td>
                                        <td>{{ $payment->payment_daysWorked ?? 'algo' }}</td>
                                        <td>${{ $payment->payment_amount ?? 'algo' }}</td>
                                        <td class="needUppercase" style="text-transform: uppercase">{{ $payment->payment_place ?? 'algo' }}</td>
                                        <td class="needUppercase">{{ $payment->payment_dimentions ?? 'algo' }}</td>
                                        <td class="needUppercase">{{ $payment->payment_activities ?? 'algo' }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('payments.dwnlpdf', $payment->payment_id) }}"
                                                target="_blank"> <i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>

                                            <a class="btn btn-danger" href="{{ route('payment.cancel', $payment->payment_id) }}"
                                                onclick="return confirm('¿Seguro que desea borrar este pago?')"> 
                                                <i class="fa-solid fa-trash-can"></i> Cancelar pago</a>
                                        </td>
                                        
                                        {{-- <td>{{ $payment->payment_folio }}</td>
                                        <td class="text-uppercase">{{ $payment->payment_name }}</td>
                                        <td>{{ $payment }}</td>
                                        <td>{{ date('d-m-Y', strtotime($payment->payment_startingDate)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($payment->payment_endingDate)) }}</td>
                                        vc 
                                        <td>{{ $payment->payment_daysText }}</td>
                                        <td>${{ number_format($payment->payment_amount, 2) }}</td>
                                        <td>{{ $payment->payment_place }}</td>
                                        <td>{{ $payment->payment_dimentions }}m</td>
                                        <td>{{ $payment->payment_activities }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('payments.dwnlpdf', $payment) }}"
                                                target="_blank"> <i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>

                                            <a class="btn btn-danger" href="{{ route('payment.cancel', $payment) }}"
                                                onclick="return confirm('¿Seguro que desea borrar este pago?')"> <i
                                                    class="fa-solid fa-trash-can"></i> Cancelar pago</a>

                                        </td> --}}
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
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
        <script>
            $(document).ready(function() {
                $("#generar").click(function() {
                    from = document.getElementById('initialDate').value,
                    to = document.getElementById('finalDate').value,
                    //console.log(token, from, to)    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                            type: "POST",
                            url: '/mostrarReporte',
                            dataType: 'json',
                            timeout: 1000,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                from: from,
                                to: to,
                            }

                        }).done(function(respuesta) {
                            //console.log(respuesta)
                            var clase = [];
                            var total = [];
                            for (let index = 0; index < respuesta.length; index++) {
                                clase[index] = respuesta[index].clase
                                total[index] = respuesta[index].total
                            }
                            //console.log(clase, total)

                            if (clase[0] != null && total[0] != null) {
                                $("#mostrarA").val(clase[0] + ": $" + total[
                                    0]); // ID de la 1era caja de texto
                            } else {
                                $("#mostrarA").val("No hay.");
                            }
                            if (clase[1] != null && total[1] != null) {
                                $("#mostrarS").val(clase[1] + ": $" + total[
                                    1]); // ID de la 2da caja de texto
                            } else {
                                $("#mostrarS").val("No hay.");
                            }
                            if (clase[2] != null && total[2] != null) {
                                $("#mostrarT").val(clase[2] + ": $" + total[
                                    2]); // ID de la 3ra caja de texto
                            } else {
                                $("#mostrarT").val("No hay.");
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR, textStatus, errorThrown)
                        })
                });


            });
        </script>
    @endsection
</div>
@endsection
