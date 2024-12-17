@extends('layouts.carcasa')

@section('css')
@endsection

@section('title')
    <title>Registrar pago {{ $local->RLocalsCategories->category_type }}</title>
@endsection

@section('content')

<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nuevo pago del comerciante con CURP: {{ Str::upper($merchant->merchant_curp) }}. </div>
                    <form id="formulario" class="px-3" action="{{ route('payment.saveOcationalPayment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="merchant_id" id="merchant_id" value="{{ $merchant->merchant_id }}">
                        <input type="hidden" name="local_id" id="local_id" value="{{ $local->local_id }}">
                        <input type="hidden" name="totalExtra" id="totalExtra" value="{{ $totalExtra }}">
                        <input type="hidden" name="category" id="category" value="{{ $local->RLocalsCategories->category_type }}">
                        <input type="hidden" name="localVenue" id="localVenue" value="{{ $local->RLocalsMarkets->market_name }}">
                        
                        <div class="d-flex justify-content-start row ">
                            <div class="mb-3 col-4 border">
                                <label for="name" class="form-label">Nombre: </label>
                                <input type="text" name="name" class="form-control text-uppercase" value="{{ $merchant->merchant_names }}" 
                                    id="name" aria-describedby="nameHelp" readonly>
                                <div id="nameHelp" class="form-text ">Nombre del comerciante que va a pagar.</div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-5 border">
                                <label for="business" class="form-label">Giro(s): </label>
                                <input type="text" name="business" class="form-control text-uppercase" value="{{ $local->local_activity }}" 
                                    id="business" aria-describedby="businessHelp" readonly hidden>
                                <input type="text"  class="form-control text-uppercase" value="{{ trim($local->local_activity, ',') }}" readonly>
                                <div id="businessHelp" class="form-text">Giro(s).</div>
                                @error('business')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="curp" class="form-label">CURP: </label>
                                <input type="text" name="curp" class="form-control text-uppercase" id="curp" value="{{ $merchant->merchant_curp }}" 
                                    aria-describedby="folioHelp" readonly>
                                <div id="curpHelp" class="form-text">Clave única de registro de población. </div>
                                
                            </div>
                            <div class="mb-3 col-12 border">
                                <label for="ubication" class="form-label">Ubicación: </label>
                                <input type="text" name="ubication" id="ubication" class="form-control text-uppercase" value="{{ $local->local_location }}"
                                    aria-describedby="ubicationHelp" readonly>
                                <div id="ubicationHelp" class="form-text">Ubicación del local.</div>
                                @error('ubication')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 border">
                                <div class="row " id="dias">
                                    <div class="@error('dia') is-invalid @enderror"></div>
                                    <label for="dias" class="form-label" aria-describedby="diasHelp">Días laborales: </label>
                                    <input type="text" name="days" id="daysN" value="{{ $local->local_days }}" aria-describedby="daysHelp" readonly hidden>
                                    <div class="d-flex justify-content-left col wrap border align-items-center p-2">
                                        <input type="checkbox" name="day1" value="1" onchange="nDays(1)" data-id="1"
                                            class="form-check-input m-1" id="day1"
                                            @if (stristr($local->local_days, '1')) 
                                                checked
                                            @endif>
                                        <label class="form-check-label" for="day1"> Lunes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day2" value="2" onchange="nDays(2)"
                                            class="form-check-input m-1" id="day2"
                                            @if (stristr($local->local_days, '2')) 
                                                checked
                                            @endif>
                                        <label class="form-check-label" for="day2"> Martes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day3" value="3" onchange="nDays(3)"
                                            class="form-check-input m-1" id="day3"
                                            @if (stristr($local->local_days, '3')) 
                                                checked
                                            @endif>
                                        <label class="form-check-label" for="day3"> Miércoles</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day4" value="4" onchange="nDays(4)"
                                            class="form-check-input m-1" id="day4"
                                            @if (stristr($local->local_days, '4')) 
                                                checked
                                            @endif>
                                        <label class="form-check-label" for="day4"> Jueves</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day5" value="5" onchange="nDays(5)"
                                            class="form-check-input m-1" id="day5"
                                            @if (stristr($local->local_days, '5')) 
                                                checked
                                            @endif >
                                        <label class="form-check-label" for="day5"> Viernes</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day6" value="6" onchange="nDays(6)"
                                            class="form-check-input m-1" id="day6"
                                            @if (stristr($local->local_days, '6')) 
                                                checked
                                            @endif>
                                        <label class="form-check-label" for="day6"> Sábado</label>
                                    </div>
                                    <div class="d-flex justify-content-left col border align-items-center p-2">
                                        <input type="checkbox" name="day7" value="7" onchange="nDays(7)"
                                            class="form-check-input m-1" id="day7"
                                            @if (stristr($local->local_days, '7')) {
                                                    checked
                                                } 
                                            @endif>
                                        <label class="form-check-label" for="day7"> Domingo</label>
                                    </div>
                                    @error('dia')
                                        <span class="invalid-feedback col-12 p-3"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <div id="diasHelp" class="form-text">Ingrese los días que laborará el comerciante.</div>
                                </div>
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="cost" class="form-label">Monto fiscal: </label>
                                <select name="cost" id="fiscalAmount" class="form-control" onchange="newValue()" required>
                                    <option value="0" disabled selected>Seleccione un monto</option>
                                    @foreach ($montos as $monto)
                                        <option value="{{ $monto->amount_cost }}" >Año: {{ $monto->amount_year }} - Precio: ${{ number_format($monto->amount_cost, 2) }}</option>
                                    @endforeach
                                </select>
                                <p class="placeholder-glow">
                                    <span class="placeholder col-12 bg-primary"></span>
                                </p>
                            </div>
                            @if ($totalExtra <> 0)
                                <div class="mb-3 col-3 border">
                                    <label for="extraMeter" class="form-label"> Precio del metro extra: </label>
                                    <select name="extraMeter" id="extraMeter" class="form-control" onchange="startingDate()" disabled="disabled" required>
                                        <option value="0" disabled selected>Seleccione un monto</option>
                                        @foreach ($extras as $extra)
                                            <option value="{{ $extra->amount_cost }}" >Año: {{ $extra->amount_year }} - Precio: ${{ number_format($extra->amount_cost, 2) }}</option>
                                        @endforeach
                                        
                                    </select>
                                    <div id="extraMeter" class="form-text"></div>
                                </div>
                            @endif
                            <div class="mb-3 col-3 border col align-self-center">
                                <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio: </label>
                                <input type="date" id="IDatePayment" name="IDatePayment" class="form-control" disabled="disabled" 
                                    aria-describedby="iDateHelp" onchange="activateDateEnd()" required>
                                <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                            </div>
                            <div class="mb-3 col-3 border col align-self-center" id="FF" >
                                <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización: </label>
                                <input type="date" id="FDatePayment" name="FDatePayment" disabled="disabled" class="form-control" 
                                    min="{{ $local->payment_endingDate ?? '' }}" aria-describedby="fDateHelp" onchange="daysDifference()" required>
                                <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                            </div>
                            <div class="mb-3 col-6 border">
                                <label for="measurements" class="form-label">@if ($local->local_places == 1)
                                    Medidas del lugar:
                                @else
                                    Medidas de los lugares:
                                @endif </label>
                                <input type="text" id="places" value="{{ $local->local_places }}" readonly hidden>
                                <input type="text" name="measurements" id="measurements" class="form-control" 
                                    {{-- @if ($local->local_places == 1)
                                        value="{{ $local->local_dimx }} x {{ $local->local_dimy }}m"
                                    @else
                                        value="@foreach($lugares as $lugar){{ $lugar->place_dimx }}x{{ $lugar->place_dimy}}@if($lugar->place_extra <> 0) + {{ $lugar->place_extra }} @endif , @endforeach m" 
                                    @endif --}}
                                    @if ($local->local_places == 1)
                                        @if ($totalExtra == 0)
                                            value="Lugar: 1"
                                        @else
                                            @if ($totalExtra == 1)
                                                value="Lugar: {{ count($lugares) }} + {{ $totalExtra }} metro extra" 
                                            @else
                                                value="Lugar: {{ count($lugares) }} + {{ $totalExtra }} metros extra" 
                                            @endif
                                        @endif
                                    @else 
                                        @if ($totalExtra <> 0)
                                            @if ($totalExtra == 1)
                                                value="Lugares: {{ count($lugares) }} + {{ $totalExtra }} metro extra" 
                                            @else
                                                value="Lugares: {{ count($lugares) }} + {{ $totalExtra }} metros extra" 
                                            @endif
                                        @else
                                            value="Lugares: {{ count($lugares) }}" 
                                        @endif
                                    @endif
                                    aria-describedby="measurementsHelp" readonly>
                                <input type="text" id="area" value="{{ number_format($local->local_area, 2) }}" readonly hidden>
                                <input type="text" id="extraMeters" value="{{ number_format($local->local_extraMeters, 2) }}" readonly hidden>
                                <div id="measurementsHelp" class="form-text">Medidas del/los lugares en metros.</div>
                                @error('measurements')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3 col-3 border">
                                <div class="input-group mb-3">
                                    <label for="value" class="form-label col-12">Cantidad del pago por día: </label> <br>
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="value" class="form-control" id="PPD" value="" aria-describedby="valueHelp" readonly>
                                    <div id="valueHelp" class="form-text">Cantidad que el ciudadano va a pagar. </div>
                                </div>
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="dWorked" class="form-label">Días laborados: </label>
                                <input type="text" name="dWorked" class="form-control" id="dWorked"  aria-describedby="dWorkedHelp" readonly>
                                <div id="dWorkedHelp" class="form-text">Cantidad de días que el ciudadano trabajó. </div>
                            </div>
                            <div class="mb-3 col-3 border">
                                <div class="input-group mb-3">
                                    <label for="subtotal" class="form-label col-12">Subtotal: </label> 
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="subtotal" class="form-control col-12" id="subtotal"  
                                        aria-describedby="subtotalHelp" readonly>
                                    <div id="subtotalHelp" class="form-text col-12">Esta es la suma total de los costos. </div>
                                </div>
                            </div>
                            <div class="mb-3 col-3 border">
                                <div class="input-group mb-3">
                                    <label for="tarifAdjustment" class="form-label col-12">Ajuste tarifario: </label> 
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="tarifAdjustment" class="form-control col-12" id="tarifAdjustment"  
                                        aria-describedby="tarifAdjustmentHelp" readonly>
                                    <div id="tarifAdjustmentHelp" class="form-text col-12">Cambio realizado en la tarifa original . </div>
                                </div>
                            <div class="mb-3 col-3 border">
                                <div class="input-group mb-3">
                                    <label for="total" class="form-label col-12">Total: </label> 
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="total" class="form-control col-12" id="total"  
                                        aria-describedby="totalHelp" onchange="setTwoNumberDecimal" readonly>
                                    <div id="totalHelp" class="form-text col-12">Monto que el ciudadano pagará. </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="mb-3 col-6 ps-3">
                        <div class="mb-3 ml-10 form-check">
                            <input type="checkbox" class="form-check-input" id="check" required>
                            <label class="form-check-label" for="check">Los datos son correctos <label>
                        </div>
                        <button class="btn btn-primary col-5" id="btn" type="submit" value="Submit"
                            onclick="show_my_receiptOca({{ $local->local_id }})" 
                            >Generar pago </button> 
                        {{-- <button type="submit" class="btn btn-primary col-3">Generar pago</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('payments.js.calcsOcationals')
    
@endsection