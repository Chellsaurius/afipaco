@extends('layouts.carcasa')

@section('title')
    <title>Añadir comerciante</title>
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
                    <div class="card-header">Añadir un nuevo comerciante</div>
                    <div class="col-md-12 row mt-2">
                        <div class="mb-3 col-5 ms-3">
                            <h3 for="curp" class="form-label">Verificación del comerciante</h3>
                            <input type="text" id="scurp" class="form-control text-uppercase " autocomplete="on"
                                id="curp" aria-describedby="nameHelp" autofocus="on">
                            <div id="curpHelp" class="form-text">Ingrese 8 digitos la CURP para verificar (pueden haber homologos).</div>
                            @error('merchant_curp')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-6  mb-4" style="align-self: center">
                            <button class="btn btn-primary col-3" onclick="searchMerchant()">Buscar</button>
                        </div>
                        @include('merchants.js.searchMerchant')
                        <div id="showResult" class="mb-3 col-12 ms-3"></div>
                    </div>
                    <hr>
                    <h3 class="ms-3">Registro del comerciante</h3>
                    <form class="row ms-3" action="{{ route('merchant.saveNew') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-start row">
                            <div class="mb-3 col-6 border">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" name="nombre" class="form-control text-uppercase  @error('nombre') is-invalid @enderror " value="{{ old('nombre') }}" 
                                    id="nombre" aria-describedby="nombreHelp" required>
                                <div id="nombreHelp" class="form-text">Ingrese el o los nombres.</div>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="curp" class="form-label">CURP</label>
                                <input type="text" name="merchant_curp" class="form-control text-uppercase @error('merchant_curp') 
                                    is-invalid @enderror" value="{{ old('merchant_curp') }}" 
                                    maxlength="18" id="curp" aria-describedby="curpHelp" required>
                                <div id="curpHelp" class="form-text">Ingrese la CURP.</div>
                                @error('merchant_curp')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="rfc" class="form-label">RFC (opcional)</label>
                                <input type="text" name="merchant_rfc" class="form-control text-uppercase @error('merchant_rfc') 
                                    is-invalid @enderror" value="{{ old('merchant_rfc') }}"
                                    maxlength="18" id="rfc" aria-describedby="rfcHelp" required>
                                <div id="rfcHelp" class="form-text">Ingrese la clave RFC.</div>
                                @error('merchant_rfc')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 border">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type=text name="direccion" class="form-control text-uppercase @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}" 
                                    id="direccion" aria-describedby="direccionHelp" required>
                                <div id="direccionHelp" class="form-text">Ingrese la dirección personal del comerciante.</div>
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="telefono1" class="form-label">Teléfono 1 (opcional)</label>
                                <input type=text name="telefono1" class="form-control @error('telefono1') is-invalid @enderror" value="{{ old('telefono1') }}" autocomplete="off"
                                    pattern="[0-9]{10}" onkeypress="return !(event.charCode == 46)" onkeydown="return event.keyCode !== 190"
                                    id="telefono1" aria-describedby="telefono1Help">
                                <div id="telefono1Help" class="form-text">Ingrese el teléfono principal.</div>
                                @error('telefono1')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <!-- autocomplete="off" -->
                            </div>
                            <div class="mb-3 col-3 border">
                                <label for="telefono2" class="form-label">Teléfono 2 (opcional)</label>
                                <input type=text name="telefono2" class="form-control  @error('telefono2') is-invalid @enderror" value="{{ old('telefono2') }}" autocomplete="off"
                                    pattern="[0-9]{10}" onkeypress="return !(event.charCode == 46)" onkeydown="return event.keyCode !== 190"
                                    id="telefono2" aria-describedby="telefono2Help" >
                                <div id="telefono2Help" class="form-text">Ingrese el teléfono alternativo, opcional.</div>
                                @error('telefono2')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 ml-4">
                            <div class="mb-3 form-check col-6 ">
                                <input type="checkbox" class="form-check-input" id="finalCheck" required>
                                <label class="form-check-label" for="finalCheck">Los datos del comerciante son correctos </label>
                            </div>
                        </div>
                        <div class="col-12 ml-4">
                            <button type="submit" class="btn btn-primary col-3">Siguiente</button>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>  
    </div>
    
        
@endsection
