@extends('layouts.carcasa')

@section('title')
    <title>Registrar pago {{ $local->RLocalsCategories->category_type }}</title>
@endsection

@section('content')

    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Nuevo pago del comerciante con CURP: {{ Str::upper($merchant->merchant_curp) }} </div>
                        <form id="formulario" class="pt-2 px-3">
                            <input type="hidden" name="merchant_id" id="merchant_id{{ $local->local_id }}" value="{{ $merchant->merchant_id }}">
                            <input type="hidden" name="local_id" id="local_id{{ $local->local_id }}" value="{{ $local->local_id }}">
                            <input type="hidden" name="category" id="category{{ $local->local_id }}" value="{{ $local->RLocalsCategories->categor_type}}">
                            <input type="hidden" name="localVenue" id="localVenue{{ $local->local_id }}" value="{{ $local->RLocalsTianguis->tiangui_name }}">

                            <div class="d-flex justify-content-start row ">
                                <div class="mb-3 col-4 border">
                                    <label for="name" class="form-label">Nombre:</label>
                                    <input type="text" name="name" id="name{{ $local->local_id }}" class="form-control text-uppercase" 
                                        value="{{ $merchant->merchant_names }}" aria-describedby="nameHelp" readonly>
                                    <div id="nameHelp" class="form-text ">Nombre del comerciante que va a pagar.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-5 border">
                                    <label for="business" class="form-label">Giro(s):</label>
                                    <input type="text" name="business" id="business{{ $local->local_id }}" class="form-control" 
                                        value="{{ $local->local_activity }}" aria-describedby="businessHelp" readonly hidden>
                                    <input type="text"  class="form-control text-uppercase" value="{{ trim($local->local_activity, ',') }}"   readonly>
                                    <div id="businessHelp" class="form-text">Actividades del comerciante.</div>
                                    @error('business')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-3 border">
                                    <label for="curp" class="form-label">CURP:</label>
                                    <input type="text" name="curp" class="form-control text-uppercase" id="curp{{ $local->local_id }}" 
                                        value="{{ $merchant->merchant_curp }}" aria-describedby="folioHelp" readonly>
                                    <div id="curpHelp" class="form-text">Clave única de registro de población. </div>
                                    
                                </div>
                                <div class="mb-3 col-12 border">
                                    <label for="ubication" class="form-label">Ubicación:</label>
                                    <input type="text" name="ubication" class="form-control text-uppercase" 
                                        value="{{ $local->local_location }}" id="ubication{{ $local->local_id }}" aria-describedby="ubicationHelp" readonly>
                                    <div id="ubicationHelp" class="form-text">Ubicación del local.</div>
                                    @error('ubication')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                
                                <div class="col-12 mb-3  row">
                                    <div class="mb-3 col-8 border">
                                        <label for="days" class="form-label">Dias</label>
                                        <input type="text" name="days{{ $local->local_id }}" id="daysN{{ $local->local_id }}" 
                                            value="{{ $local->local_days }}" aria-describedby="daysHelp" readonly hidden>
                                        <input type="text" name="daysPayed" id="daysT{{ $local->local_id }}" class="form-control text-uppercase" 
                                            value="{{ trim($local->local_daysText, ',') }}" readonly>
                                        <div id="daysHelp" class="form-text">Dias que labora el comerciante:</div>
                                        @error('days')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-4 border">
                                        <label for="cost" class="form-label">Monto fiscal: </label>
                                        <select name="cost" id="fiscalAmount{{ $local->local_id }}" class="form-control" onchange="newValue({{ $local->local_id }})">
                                            <option value="0" disabled selected>Seleccione un monto</option>
                                            @foreach ($montos as $monto)
                                                <option value="{{ $monto->amount_cost }}" >Año: {{ $monto->amount_year }} - Precio: ${{ number_format($monto->amount_cost, 2) }}</option>
                                            @endforeach
                                        </select>
                                        <p class="placeholder-glow">
                                            <span class="placeholder col-12 bg-primary"></span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mb-3 col-3 border col align-self-center" id="FI{{ $local->local_id }}">
                                    <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio: </label>
                                    <input type="date" id="IDatePayment{{ $local->local_id }}" name="IDatePayment" class="form-control" disabled="disabled"
                                        aria-describedby="iDateHelp" onchange="activateDateEnd({{ $local->local_id }})" required>
                                    <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                                </div>
                                <div class="mb-3 col-3 border col align-self-center" id="FF{{ $local->local_id }}" >
                                    <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización: </label>
                                    <input type="date" id="FDatePayment{{ $local->local_id }}" name="FDatePayment" disabled="disabled" class="form-control" min="{{ $local->payment_endingDate ?? '' }}"
                                        aria-describedby="fDateHelp" onchange="daysDifference({{ $local->local_id }})" required >
                                    <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                                </div>
                                
                                <div class="mb-3 col-6 border">
                                    <label for="measurements" class="form-label">
                                        @if ($local->local_places == 1)
                                            Medidas del lugar
                                        @else
                                            Medidas de los lugares
                                        @endif 
                                    </label>
                                    <input type="text" id="area{{ $local->local_id }}" value="{{ number_format($local->local_area, 2) }}" readonly hidden>
                                    <input type="text" name="measurements" id="measurements{{ $local->local_id }}" class="form-control" 
                                        @if ($local->local_places == 1)
                                            value="{{ $local->local_dimx }} x {{ $local->local_dimy }}m"
                                        @else
                                            value="@foreach($lugares as $lugar){{ $lugar->place_dimx }}x{{ $lugar->place_dimy }} @endforeach m" 
                                        @endif
                                        aria-describedby="measurementsHelp" readonly>
                                    <div id="measurementsHelp" class="form-text">Medidas del/los lugares en metros:</div>
                                    @error('measurements')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-3 border">
                                    <div class="input-group mb-3">
                                        <label for="value" class="form-label">Cantidad del pago por los día: </label>
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="value" class="form-control" id="PPD{{ $local->local_id }}" value="" aria-describedby="valueHelp" readonly>
                                        <div id="valueHelp" class="form-text">Cantidad que el ciudadano va a pagar. </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-3 border">
                                    <label for="dWorked" class="form-label">Días laborados: </label>
                                    <input type="text" name="dWorked" class="form-control" id="dWorked{{ $local->local_id }}"  aria-describedby="dWorkedHelp" readonly>
                                    <div id="dWorkedHelp" class="form-text">Cantidad de días que el ciudadano trabajó. </div>
                                </div>
                                <div class="mb-3 col-3 border">
                                    <div class="input-group mb-3">
                                        <label for="subtotal" class="form-label col-12">Subtotal: </label> 
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="subtotal" class="form-control col-12" id="subtotal{{ $local->local_id }}"  
                                            aria-describedby="subtotalHelp" readonly>
                                        <div id="subtotalHelp" class="form-text col-12">Esta es la suma total de los costos. </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-3 border">
                                    <div class="input-group mb-3">
                                        <label for="tarifAdjustment" class="form-label col-12">Ajuste tarifario: </label> 
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="tarifAdjustment" class="form-control col-12" id="tarifAdjustment{{ $local->local_id }}"  
                                            aria-describedby="tarifAdjustmentHelp" readonly>
                                        <div id="tarifAdjustmentHelp" class="form-text col-12">Cambio realizado en la tarifa original . </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-3 border">
                                    <div class="input-group mb-3">
                                        <label for="total" class="form-label col-12">Total: </label> 
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="total" class="form-control col-12" id="total{{ $local->local_id }}"  
                                            aria-describedby="totalHelp" onchange="setTwoNumberDecimal" readonly>
                                        <div id="totalHelp" class="form-text col-12">Monto que el ciudadano pagará. </div>
                                    </div>
                                </div>
                                    
                            </div>
                        </form>
                        <div class="mb-3 col-6 ps-3">
                            <div class="mb-3 ml-10 form-check">
                                <input type="checkbox" class="form-check-input" id="check{{ $local->local_id }}" required>
                                <label class="form-check-label" for="check{{ $local->local_id }}">Los datos son correctos <label>
                            </div>
                            <button class="btn btn-primary col-5" id="btn{{ $local->local_id }}" onclick="show_my_receiptTia({{ $local->local_id }})">Generar pago </button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('payments.js.calcsTianguis')
@endsection