<div class="modal fade" id="completarPagoModal{{ $payment->payment_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Completar el pago </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('payment.saveFolio') }}" method="POST" >
                    @csrf
                    <input type="hidden" name="payment_id" value="{{ $payment->payment_id }}">
                    <input type="hidden" name="merchant_id" value="{{ $payment->merchant_id }}">
                    <input type="hidden" name="local_id" value="{{ $payment->local_id }}">
                    <div class="d-flex justify-content-between row ">
                        <div class="mb-3 col-4 border">
                            <label for="name" class="form-label">Nombres</label>
                            <input type="text" name="name" class="form-control text-uppercase" value="{{ $payment->payment_name }}" id="name" 
                                aria-describedby="nameHelp" readonly>
                            <div id="nameHelp" class="form-text">Nombres del ciudadano. </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-5 border">
                            <label for="business" class="form-label">Giro</label>
                            <input type="text" name="business" class="form-control text-uppercase" value="{{ trim($payment->payment_activities, ',') }}" 
                                id="business" aria-describedby="businessHelp" readonly >
                            <div id="businessHelp" class="form-text">Giro(s).</div>
                            @error('business')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="folio" class="form-label">Folio</label>
                            <input type="text" name="folio" class="form-control text-uppercase" id="folio{{ $payment->payment_id }}" 
                                aria-describedby="folioHelp" placeholder="Ejemplo: AA12345678" required>
                            <div id="folioHelp" class="form-text">Folio a registrar. </div>
                            @error('folio')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <div class="mb-3 col-12 border">
                            <label for="ubication" class="form-label">Ubicación</label>
                            <input type="text" name="ubication" class="form-control text-uppercase" value="{{ $payment->payment_place }}" 
                                id="ubication" aria-describedby="ubicationHelp" readonly>
                            <div id="ubicationHelp" class="form-text">Ubicación del local.</div>
                            @error('ubication')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-6 border">
                            <label for="days" class="form-label">Dias</label>
                            <input type="text" name="days" class="form-control" value="{{ $payment->payment_daysWorked }}" 
                                id="days" aria-describedby="daysHelp" readonly hidden>
                            <input type="text"  class="form-control text-uppercase" value="{{ trim($payment->payment_daysText, ',') }}"   readonly>
                            <div id="daysHelp" class="form-text">Dias que labora el comerciante.</div>
                            @error('days')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border col align-self-center">
                            <label for="IDatePayment" class="form-label"> Fecha de inicio. </label>
                            <input type="text" id="IDatePayment" name="IDatePayment" class="form-control" 
                                value="{{ date_format(date_create($payment->payment_startingDate), 'd/m/Y') }}" aria-describedby="iDateHelp" readonly>
                            <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                        </div>
                        <div class="mb-3 col-3 border col align-self-center">
                            <label for="FDatePayment" class="form-label"> Fecha de finalización. </label>
                            <input type="text" id="FDatePayment" name="FDatePayment" class="form-control" 
                                value="{{ date_format(date_create($payment->payment_endingDate), 'd/m/Y') }}" aria-describedby="fDateHelp" readonly >
                            <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                        </div>
                    
                        <div class="mb-3 col-6 border">
                            <label for="measurements" class="form-label">Medidas.</label>
                            <input type="text" name="measurment" class="form-control text-uppercase" id="measurements" 
                                value="{{ $payment->payment_dimentions }}" 
                                    aria-describedby="measurementsHelp" readonly>
                            <div id="measurementHelp" class="form-text">Medidas del local del comerciante. </div>
                        </div>
                        
                        <div class="mb-3 col-3 border">
                            <label for="value" class="form-label">Cantidad del pago por los día. $</label>
                            <input type="number" name="value" class="form-control" id="value" 
                                value="{{ number_format(($payment->payment_amount / $payment->payment_daysWorked), 2) }}" aria-describedby="valueHelp" readonly>
                            <div id="valueHelp" class="form-text">Cantidad que el ciudadano va a pagar. </div>
                            
                        </div>
                        
                            <div class="mb-3 col-3 border">
                                <label for="dWorked" class="form-label">Días laborados: </label>
                                <input type="text" name="dWorked" class="form-control text-uppercase" id="dWorked" value="{{ $payment->payment_daysWorked }}" 
                                    aria-describedby="dWorkedHelp" readonly>
                                <div id="dWorkedHelp" class="form-text">Cantidad de días que el ciudadano trabajó. </div>
                                
                            </div>
                            <div class="mb-3 col-3 border">
                                <div class="input-group mb-3">
                                    <label for="total" class="form-label col-12">Total: </label> 
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="total" class="form-control col-12" id="total" value="{{ number_format($payment->payment_amount, 2) }}"
                                        aria-describedby="totalHelp" onchange="setTwoNumberDecimal" readonly>
                                    <div id="totalHelp" class="form-text col-12">Monto que el ciudadano pagará. </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 col-6 ">
                                <div class="mb-3 ml-10 form-check ">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck{{ $payment->payment_id }}" required>
                                    <label class="form-check-label" for="exampleCheck{{ $payment->payment_id }}">Los datos son correctos</label>

                                </div>
                                <button type="submit" class="btn btn-primary col-3 " >Completar pago</button> 

                            </div>
                        
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>


