
<div class="modal fade" id="pagarModalOcasional{{ $record->RRecordsLocals->local_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Generar pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formulario">
                        <input type="hidden" name="merchant_id" id="merchant_id{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsMerchant->merchant_id }}">
                        <input type="hidden" name="local_id" id="local_id{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->local_id }}">
                        <input type="hidden" name="totalExtra" id="totalExtra{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->RLocalPlaces->sum('place_extra') }}">
                        <input type="hidden" name="category" id="category{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->RLocalsCategories->category_type}}">
                        <input type="hidden" name="localVenue" id="localVenue{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->RLocalsMarkets->market_name }}">
                        
                        <div class="d-flex justify-content-start row ">
                            <div class="mb-3 col-4 border">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" class="form-control text-uppercase" value="{{ $merchant->merchant_names }}" 
                                    id="name{{ $record->RRecordsLocals->local_id }}" aria-describedby="nameHelp" readonly>
                                <div id="nameHelp" class="form-text ">Nombre del comerciante que va a pagar.</div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-5 border">
                                <label for="business" class="form-label">Giro</label>
                                <input type="text" name="business" class="form-control text-uppercase" value="{{ $record->RRecordsLocals->local_activity }}" 
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
                                    value="{{ $merchant->merchant_curp }}" aria-describedby="folioHelp" readonly>
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
                            <div class="mb-3 col-12 border">
                                <div class="row ">
                                    <div class="@error('dia') is-invalid @enderror"></div>
                                    <label for="dias" class="form-label" aria-describedby="diasHelp">Días laborales</label>
                                    <input type="text" name="days" id="daysN{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->local_days }}" aria-describedby="daysHelp" readonly hidden>
                                    <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                        <input type="checkbox" name="day1" value="1" onchange="nDays({{ $record->RRecordsLocals->local_id }}, event)"
                                            class="form-check-input m-1" id="day1{{ $record->RRecordsLocals->local_id }}"
                                            @if (stristr($record->RRecordsLocals->local_days, '1')) {  
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day1{{ $record->RRecordsLocals->local_id }}"> Lunes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day2" value="2" onchange="nDays({{ $record->RRecordsLocals->local_id }}, event)"
                                            class="form-check-input m-1" id="day2{{ $record->RRecordsLocals->local_id }}"
                                            @if (stristr($record->RRecordsLocals->local_days, '2')) {
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day2{{ $record->RRecordsLocals->local_id }}"> Martes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day3" value="3" onchange="nDays({{ $record->RRecordsLocals->local_id }}, event)"
                                            class="form-check-input m-1" id="day3{{ $record->RRecordsLocals->local_id }}"
                                            @if (stristr($record->RRecordsLocals->local_days, '3')) {
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day3{{ $record->RRecordsLocals->local_id }}"> Miércoles</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day4" value="4" onchange="nDays({{ $record->RRecordsLocals->local_id }}, event)"
                                            class="form-check-input m-1" id="day4{{ $record->RRecordsLocals->local_id }}"
                                            @if (stristr($record->RRecordsLocals->local_days, '4')) {
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day4{{ $record->RRecordsLocals->local_id }}"> Jueves</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day5" value="5" onchange="nDays({{ $record->RRecordsLocals->local_id }}, event)"
                                            class="form-check-input m-1" id="day5{{ $record->RRecordsLocals->local_id }}"
                                            @if (stristr($record->RRecordsLocals->local_days, '5')) {
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day5{{ $record->RRecordsLocals->local_id }}"> Viernes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day6" value="6" onchange="nDays({{ $record->RRecordsLocals->local_id }}, event)"
                                            class="form-check-input m-1" id="day6{{ $record->RRecordsLocals->local_id }}"
                                            @if (stristr($record->RRecordsLocals->local_days, '6')) {
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day6{{ $record->RRecordsLocals->local_id }}"> Sábado</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day7" value="7" onchange="nDays({{ $record->RRecordsLocals->local_id }}, event)"
                                            class="form-check-input m-1" id="day7{{ $record->RRecordsLocals->local_id }}"
                                            @if (stristr($record->RRecordsLocals->local_days, '7')) {
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day7{{ $record->RRecordsLocals->local_id }}"> Domingo</label>
                                    </div>
                                    @error('dia')
                                        <span class="invalid-feedback col-12 p-3"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <div id="diasHelp" class="form-text">Ingrese los días que laborará el comerciante.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3 col-3 border">
                                <label for="cost" class="form-label">Monto fiscal: </label>
                                <select name="cost" id="fiscalAmount{{ $record->RRecordsLocals->local_id }}" class="form-control" 
                                    onchange="newValueOca({{ $record->RRecordsLocals->local_id }})">
                                    <option value="0" disabled selected>Seleccione un monto</option>
                                    @foreach ($montos as $monto)
                                        @if ($monto->regulation_id == 2)
                                            <option value="{{ $monto->amount_cost }}" >Año: {{ $monto->amount_year }} - Precio: ${{ number_format($monto->amount_cost, 2) }}</option>
                                        @endif
                                        
                                    @endforeach
                                    
                                </select>
                            </div>
                            @if ($record->RRecordsLocals->RLocalPlaces->sum('place_extra') <> 0)
                                <div class="mb-3 col-3 border">
                                    <label for="extraMeter" class="form-label"> Precio del metro extra. </label>
                                    <select name="extraMeter" id="extraMeter{{ $record->RRecordsLocals->local_id }}" class="form-control" 
                                        onchange="startingDateOca({{ $record->RRecordsLocals->local_id }})" disabled="disabled" >
                                        <option value="0" disabled selected>Seleccione un monto</option>
                                        @foreach ($montos as $monto)
                                            @if ($monto->regulation_id == 3)
                                                <option value="{{ $monto->amount_cost }}" >Año: {{ $monto->amount_year }} - Precio: ${{ number_format($monto->amount_cost, 2) }}</option>
                                            @endif
                                            
                                        @endforeach
                                        
                                    </select>
                                    <div id="extraMeter" class="form-text"></div>
                                </div>
                            @endif
                            
                            <div class="mb-3 col-3 border col align-self-center">
                                <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio. </label>
                                <input type="date" id="IDatePayment{{ $record->RRecordsLocals->local_id }}" name="IDatePayment" class="form-control" 
                                    disabled="disabled" aria-describedby="iDateHelp" onchange="activateDateEndOca({{ $record->RRecordsLocals->local_id }})" required>
                                <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                            </div>
                            
                            <div class="mb-3 col-3 border col align-self-center" id="FF" >
                                <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización. </label>
                                <input type="date" id="FDatePayment{{ $record->RRecordsLocals->local_id }}" name="FDatePayment" disabled="disabled" 
                                    class="form-control" min="{{ $local->payment_endingDate ?? '' }}" aria-describedby="fDateHelp" 
                                    onchange="daysDifferenceOca({{ $record->RRecordsLocals->local_id }})" required>
                                <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                            </div>

                            <div class="mb-3 col-6 border">
                                <label for="measurements" class="form-label">
                                @if ($record->RRecordsLocals->local_places == 1)
                                    Medidas del lugar
                                @else
                                    Medidas de los lugares
                                @endif </label>
                                <input type="text" id="places{{ $record->RRecordsLocals->local_id }}" value="{{ $record->RRecordsLocals->local_places }}" readonly hidden>
                                <input type="text" name="measurements" id="measurements{{ $record->RRecordsLocals->local_id }}" class="form-control" 
                                    {{-- @if ($local->local_places == 1)
                                        value="{{ $local->local_dimx }} x {{ $local->local_dimy }}m"
                                    @else
                                        value="@foreach($lugares as $lugar){{ $lugar->place_dimx }}x{{ $lugar->place_dimy}}@if($lugar->place_extra <> 0) + {{ $lugar->place_extra }} @endif , @endforeach m" 
                                    @endif --}}
                                    @if ($record->RRecordsLocals->local_places == 1)
                                        @if ($record->RRecordsLocals->RLocalPlaces->sum('place_extra') == 0)
                                            value="Lugar: 1" 
                                        @else
                                            @if ($record->RRecordsLocals->RLocalPlaces->sum('place_extra') == 1)
                                                value="Lugar: {{ $record->RRecordsLocals->RLocalPlaces }} + {{ $record->RRecordsLocals->RLocalPlaces->sum('place_extra') }} metro extra" 
                                            @else
                                                value="Lugar: {{ $record->RRecordsLocals->RLocalPlaces }} + {{ $record->RRecordsLocals->RLocalPlaces->sum('place_extra') }} metros extra" 
                                            @endif
                                        @endif
                                        
                                    @else 
                                        @if ($record->RRecordsLocals->RLocalPlaces->sum('place_extra') <> 0)
                                            @if ($record->RRecordsLocals->RLocalPlaces->sum('place_extra') == 1)
                                                value="Lugares: {{ $record->RRecordsLocals->local_places }} + {{ $record->RRecordsLocals->RLocalPlaces->sum('place_extra') }} metro extra" 
                                            @else
                                                value="Lugares: {{ $record->RRecordsLocals->local_places }} + {{ $record->RRecordsLocals->RLocalPlaces->sum('place_extra') }} metros extra" 
                                            @endif
                                        @else
                                            value="Lugares: {{ $record->RRecordsLocals->local_places }}" 
                                        @endif 
                                        
                                    @endif
                                    
                                    aria-describedby="measurementsHelp" readonly>
                                    
                                    <input type="text" id="area{{ $record->RRecordsLocals->local_id }}" value="{{ number_format($record->RRecordsLocals->local_area, 2) }}" readonly hidden>
                                    <input type="text" id="extraMeters{{ $record->RRecordsLocals->local_id }}" value="{{ number_format($record->RRecordsLocals->local_extraMeters, 2) }}" readonly hidden>
                                <div id="measurementsHelp" class="form-text">Medidas del/los lugares en metros.</div>
                                @error('measurements')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3 col-3 border">
                                <div class="input-group mb-3">
                                    <label for="value" class="form-label col-12">Cantidad del pago por día: </label><br>
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="value" class="form-control" id="PPD{{ $record->RRecordsLocals->local_id }}" 
                                        value="" aria-describedby="valueHelp" readonly>
                                    <div id="valueHelp" class="form-text">Cantidad que el ciudadano va a pagar. </div>
                                </div>
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="dWorked" class="form-label">Días laborados: </label>
                                <input type="text" name="dWorked" class="form-control" id="dWorked{{ $record->RRecordsLocals->local_id }}"  
                                    aria-describedby="dWorkedHelp" readonly>
                                <div id="dWorkedHelp" class="form-text">Cantidad de días que el ciudadano trabajó. </div>
                            </div>
                            <div class="mb-3 col-3 border">
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
                                    <input type="number" class="form-control col-12" name="total" id="total{{ $record->RRecordsLocals->local_id }}"  
                                        aria-describedby="totalHelp" readonly >
                                    <br>
                                    <div class="col-12">
                                        <div id="totalHelp" class="form-text">Monto que el ciudadano pagará. </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <div class="mb-3 col-10 ">
                    <div class="mb-3 ml-10 form-check ">
                        <input type="checkbox" class="form-check-input" id="check{{ $record->RRecordsLocals->local_id }}" 
                            onclick="enableButton({{ $record->RRecordsLocals->local_id }})" required>
                        <label class="form-check-label" for="check{{ $record->RRecordsLocals->local_id }}">Los datos son correctos</label>
                    </div>
                    <button class="btn btn-primary col-3 " id="btn{{ $record->RRecordsLocals->local_id }}" disabled="disabled" 
                            onclick="show_my_receiptOca({{ $record->RRecordsLocals->local_id }})">Generar pago</button> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>


@include('payments.js.calcsModalOcational')