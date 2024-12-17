<div class="modal fade" id="pagarModalOtros{{ $record->RRecordsLocals->local_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Generar nueva orden de pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                    <input type="hidden" name="merchant_id" id="merchant_id{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsMerchant->merchant_id }}">
                    <input type="hidden" name="local_id" id="local_id{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->local_id }}">
                    <input type="hidden" name="category" id="category{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->RLocalsCategories->category_type }}">
                    <input type="hidden" name="localVenue" id="localVenue{{ $record->RRecordsLocals->local_id }}" value="Vía pública">
                    
                    <div class="d-flex justify-content-start row ">
                        <div class="mb-3 col-4 border">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control text-uppercase" value="{{ $record->RRecordsMerchant->merchant_names }}" 
                                id="name{{ $record->RRecordsLocals->local_id }}" aria-describedby="nameHelp" readonly>
                            <div id="nameHelp" class="form-text">Nombre del que pagó.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-5 border">
                            <label for="business" class="form-label">Giro</label>
                            <input type="text" name="business" class="form-control" value="{{ $record->RRecordsLocals->local_activity }}" 
                                id="business{{ $record->RRecordsLocals->local_id }}" aria-describedby="businessHelp" readonly hidden>
                            <input type="text"  class="form-control text-uppercase" value="{{ trim($record->RRecordsLocals->local_activity, ',') }}" readonly>
                            <div id="businessHelp" class="form-text">Giro(s).</div>
                            @error('business')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="curp" class="form-label">CURP</label>
                            <input type="text" name="curp" class="form-control text-uppercase" id="curp{{ $record->RRecordsLocals->local_id }}" 
                                value="{{ $record->RRecordsMerchant->merchant_curp }}" aria-describedby="folioHelp" readonly>
                            <div id="curpHelp" class="form-text">Clave única de registro de población. </div>
                            
                        </div>
                        <div class="mb-3 col-12 border">
                            <label for="ubication" class="form-label">Ubicación</label>
                            <input type="text" name="ubication" class="form-control text-uppercase" value="{{ $record->RRecordsLocals->local_location }}" 
                                id="ubication{{ $record->RRecordsLocals->local_id }}" aria-describedby="ubicationHelp" readonly>
                            <div id="ubicationHelp" class="form-text">Ubicación del local.</div>
                            @error('ubication')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-6 border">
                            <label for="days" class="form-label">Días</label>
                            <input type="text" name="days" id="daysN{{ $record->RRecordsLocals->local_id }}" class="form-control" 
                                value="{{ $record->RRecordsLocals->local_days }}" id="days" aria-describedby="daysHelp" readonly hidden>
                            <input type="text" name="daysT" id="daysT{{ $record->RRecordsLocals->local_id }}" 
                                class="form-control text-uppercase" value="{{ trim($record->RRecordsLocals->local_daysText, ',') }}" readonly>
                            <div id="daysHelp" class="form-text">Dias que labora el comerciante.</div>
                            @error('days')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="cost" class="form-label">Monto fiscal: </label>
                            <select name="cost" id="fiscalAmount{{ $record->RRecordsLocals->local_id }}" class="form-control" onchange="newValue({{ $record->RRecordsLocals->local_id }})" onchange="newValue({{ $record->RRecordsLocals->local_id }})" aria-describedby="montoHelp">
                                <option value="" disabled selected>Seleccione un monto</option>
                                @foreach ($montos as $monto)
                                    @if ($monto->regulation_id == 1)
                                        <option value="{{ $monto->amount_cost }}" >Año: {{ $monto->amount_year }} - Precio: ${{ number_format($monto->amount_cost, 2) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="montoHelp" class="form-text">Monto con el que se cobrará al comerciante.</div>
                        </div>
                        <div class="mb-3 col-3 border col align-self-center" >
                            <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio. </label>
                            <span id="aviso{{ $record->RRecordsLocals->local_id }}"></span>
                            <input type="date" id="IDatePayment{{ $record->RRecordsLocals->local_id }}" name="IDatePayment" class="form-control" 
                                aria-describedby="iDateHelp" disabled="disabled" onchange="activateDateEnd({{ $record->RRecordsLocals->local_id }})" required>                                                                   
                            <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                        </div>
                        <div class="mb-3 col-3 border col align-self-center" >
                            <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización. </label>
                            <input type="date" id="FDatePayment{{ $record->RRecordsLocals->local_id }}" name="FDatePayment" disabled="disabled" class="form-control" min="{{ $record->RRecordsLocals->payment_endingDate }}"
                                aria-describedby="fDateHelp" onchange="daysDifference({{ $record->RRecordsLocals->local_id }})" required >
                            <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                        </div>

                        <div class="mb-3 col-3 border">
                            <label for="measurements" class="form-label">Medidas.</label>
                            <input type="hidden" id="dim{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->local_dimx * $record->RRecordsLocals->local_dimy }} " readonly>
                            <input type="text" name="measurment" class="form-control" id="measurements{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->local_dimx}} x {{ $record->RRecordsLocals->local_dimy }}" aria-describedby="measurementsHelp" disabled>
                            <div id="measurementHelp" class="form-text">Medidas del local del comerciante. </div>
                        </div>
                        <input type="hidden" id="area{{ $record->RRecordsLocals->local_id }}" value="{{ number_format($record->RRecordsLocals->local_area, 2) }}" readonly >
                        <div class="mb-3 col-3 border">
                            <label for="value" class="form-label">Cantidad del pago por los día. $</label>
                            <input type="number" name="value" class="form-control" id="PPD{{ $record->RRecordsLocals->local_id }}" value="" aria-describedby="valueHelp" readonly>
                            <div id="valueHelp" class="form-text">Cantidad que el ciudadano va a pagar. </div>
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="dWorked" class="form-label">Días laborados: </label>
                            <input type="text" name="dWorked" class="form-control" id="dWorked{{ $record->RRecordsLocals->local_id }}"  aria-describedby="dWorkedHelp" readonly>
                            <div id="dWorkedHelp" class="form-text">Cantidad de días que el ciudadano trabajó. </div>
                        </div><div class="mb-3 col-3 border">
                            <div class="input-group mb-3">
                                <label for="subtotal" class="form-label col-12">Subtotal: </label> 
                                <span class="input-group-text">$</span>
                                <input type="number" name="subtotal" class="form-control col-12" id="subtotal{{ $record->RRecordsLocals->local_id }}"  
                                    aria-describedby="subtotalHelp" readonly>
                                <div id="subtotalHelp" class="form-text col-12">Esta es la suma total de los costos. </div>
                            </div>
                        </div>
                        <div class="mb-3 col-3 border">
                            <div class="input-group mb-3">
                                <label for="tarifAdjustment" class="form-label col-12">Ajuste tarifario: </label> 
                                <span class="input-group-text">$</span>
                                <input type="number" name="tarifAdjustment" class="form-control col-12" id="tarifAdjustment{{ $record->RRecordsLocals->local_id }}"  
                                    aria-describedby="tarifAdjustmentHelp" readonly>
                                <div id="tarifAdjustmentHelp" class="form-text col-12">Cambio realizado en la tarifa original . </div>
                            </div>
                        </div>
                        <div class="mb-3 col-3 border">
                            <div class="input-group mb-3">
                                <label for="total" class="form-label col-12">Total: </label> 
                                <span class="input-group-text">$</span>
                                <input type="number" name="total" class="form-control col-12" id="total{{ $record->RRecordsLocals->local_id }}" 
                                    aria-describedby="totalHelp" onchange="setTwoNumberDecimal" readonly>
                                <div id="totalHelp" class="form-text col-12">Monto que el ciudadano pagará. </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="mb-3 col-10 ">
                    <div class="mb-3 ml-10 form-check ">
                        <input type="checkbox" class="form-check-input" id="check{{ $record->RRecordsLocals->local_id }}"
                            onclick="enableButton({{ $record->RRecordsLocals->local_id }})"  required>
                        <label class="form-check-label" for="check{{ $record->RRecordsLocals->local_id }}">Los datos son correctos</label>
                    </div>
                    <button class="btn btn-primary col-5" id="btn{{ $record->RRecordsLocals->local_id }}" disabled="disabled"
                        onclick="show_my_receiptOther({{ $record->RRecordsLocals->local_id }})" >Generar orden de pago</button> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
@include('payments.js.calcsModalOthers')