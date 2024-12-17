@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    <style>
        .prueba{
            text-transform: uppercase;
        }
    </style>
@endsection

@section('title')
    <title>Pagos pendientes</title>
@endsection

@section('content')   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de pagos por capturar folio</div>

                    <div class="card-body">

                        <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Contrato</th>
                                    <th>Días laborados</th>
                                    <th>Cantidad cobrada</th>
                                    <th>Ubicación</th>
                                    <th>Giro(s)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-uppercase">
                                @foreach ($payments as $payment)
                                    <tr>
                                        
                                        <td class="text-uppercase">{{ $payment->payment_name }}</td>
                                        <td>{{ $payment->RPaymentsLocals->RLocalsCategories->category_type }}</td>
                                        <td>De: {{ date('d-m-Y', strtotime($payment->payment_startingDate)) }} a: {{ date('d-m-Y', strtotime($payment->payment_endingDate)) }}</td>
                                        <td>{{ $payment->payment_daysWorked }}</td>
                                        <td>${{ number_format($payment->payment_amount, 2) }}</td>
                                        <td class="text-uppercase">{{ $payment->payment_place }}</td>
                                        <td class="prueba">{{ trim($payment->payment_activities, ',') }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('payments.dwnlpdf', $payment->payment_id ) }}" target="_blank">
                                                <i class="fa-solid fa-file-pdf"></i> Descargar PDF
                                            </a> 
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#completarPagoModal{{ $payment->payment_id }}"
                                                onclick="setFocusOnInput({{ $payment->payment_id }})">
                                                <i class="fa-solid fa-file-invoice-dollar"></i>Completar pago
                                            </button>
                                            <a class="btn btn-danger" href="{{ route('payment.cancel', $payment->payment_id ) }}" 
                                                onclick="return confirm('¿Seguro que desea borrar este pago?')"> <i class="fa-solid fa-trash-can"></i>  Cancelar pago</a> 
                                        
                                        </td>
                                    </tr>
                                    
                                    @include('payments.modal.completePayment')
                                @endforeach
                    
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @section('js')
        <script>
            function setFocusOnInput(modalId) {
                // console.log(modalId);
                // $('#' + modalId).on('shown.bs.modal', function () {
                //     $(this).find('.autofocus-input').first().focus();
                // });
                var focus = document.getElementById('folio' + modalId);
                // document.getElementById('folio' + modalId).focus();

                const myModal = document.getElementById('completarPagoModal' + modalId)
                const myInput = document.getElementById('folio' + modalId)

                myModal.addEventListener('shown.bs.modal', () => {
                    myInput.focus()
                })

                // focus.focus();
                // console.log(focus);
            }
        </script>
        
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