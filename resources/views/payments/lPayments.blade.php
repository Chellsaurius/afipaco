@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endsection

@section('title')
    <title>Lista de pagos</title>
@endsection

@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de pagos</div>

                    <div class="card-body">
                        <table id="montos" class="table table-striped dt-responsive nowrap table-bordered" style="width:100%; text-transform: uppercase">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Nombres </th>
                                    <th>Ubicación</th>
                                    <th>Inicio de contrato</th>
                                    <th>Fin de contrato</th>
                                    <th>Días laborados</th>
                                    <th>Cantidad cobrada</th>
                                    <th>Ubicación</th>
                                    <th>Dimensiones</th>
                                    <th>Giro(s)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_folio }}</td>
                                        <td class="text-uppercase">{{ $payment->payment_name }}</td>
                                        <td>{{ $payment->payment_localVenue }} ({{ $payment->payment_daysText }})</td>
                                        <td>{{ date('d-m-Y', strtotime($payment->payment_startingDate)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($payment->payment_endingDate)) }}</td>
                                        <td style="text-transform: uppercase">{{ $payment->payment_daysText }}</td>
                                        <td>${{ number_format($payment->payment_amount, 2) }}</td>
                                        <td>{{ $payment->payment_place }}</td>
                                        <td>{{ $payment->payment_dimentions }}</td>
                                        <td>{{ trim($payment->payment_activities, ',') }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('payments.dwnlpdf', $payment->payment_id) }}"
                                                target="_blank"> <i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>

                                            <a class="btn btn-danger" href="{{ route('payment.cancel', $payment->payment_id) }}"
                                                onclick="return confirm('¿Seguro que desea borrar este pago?')"> <i
                                                    class="fa-solid fa-trash-can"></i> Cancelar pago</a>
                                            @if(Auth::user()->id == 23 || Auth::user()->id == 26 || Auth::user()->id == 1)
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editInvoice{{ $payment->payment_id }}"
                                                    onclick="setFocusOnInput({{ $payment->payment_id }})">
                                                    Editar folio pago
                                                </button>
                                                <script>
                                                    function setFocusOnInput(modalId) {
                                                        // console.log(modalId);
                                                        const myModal = document.getElementById('editInvoice' + modalId);
                                                        const myInput = document.getElementById('folio' + modalId);
                                                        
                                                        myModal.addEventListener('shown.bs.modal', () => {
                                                            myInput.focus()
                                                        })
                                                    }
                                                </script>
                                            @endif
                                        </td>
                                    </tr>
                                    @if(Auth::user()->id == 23 || Auth::user()->id == 26 || Auth::user()->id == 1)
                                        <div class="modal fade" id="editInvoice{{ $payment->payment_id }}" tabindex="-1" aria-labelledby="editInvoiceLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editInvoiceLabel">Editar folio</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('payment.editFolio') }}" method="post">
                                                            @csrf
                                                            <div class="mb-3 col-12 border">
                                                                <input type="hidden" name="id" value="{{ $payment->payment_id }}">
                                                                <label for="folio" class="form-label">Folio actual</label>
                                                                <input type="text" name="folio" class="form-control text-uppercase" value="{{ $payment->payment_folio }}" 
                                                                    id="folio{{ $payment->payment_id }}" aria-describedby="folioHelp" placeholder="Ejemplo: AA12345678" required>
                                                                <div id="folioHelp" class="form-text">Ingrese el nuevo folio a registrar. </div>
                                                                @error('folio')
                                                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                                                @enderror
                                                            </div>
                                                            <button type="submit" class="btn btn-primary col-5 " >Actualizar</button> 
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
                    // order: [[ 5, 'desc' ]],
                    order: false,
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
