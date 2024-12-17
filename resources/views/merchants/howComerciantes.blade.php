@extends('layouts.carcasa')

@section('title')
    <title>¿Cómo buscar al comerciante?</title>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        <form action="{{ route('lComerciantes') }}" method="POST" >
                            @csrf
                            <input type="hidden" name="seleccion" value="1">
                            <div class="d-flex justify-content-between row ">
                                <div class="mb-3 col-7 border">
                                    <label for="curp" class="form-label">CURP</label>
                                    <input type="text" name="curp" class="form-control text-uppercase" id="curp" minlength="18" maxlength="18" aria-describedby="curpHelp" required>
                                    <div id="curpHelp" class="form-text">CURP del comerciante a buscar.</div>
                                    @error('merchant_curp')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <br>
                                    <button type="submit" class="btn btn-primary col-5 ">Buscar comerciante por CURP </button> 
                                </div>
                                
                            </div>
                        </form>
                        <form action="{{ route('lComerciantes') }}" method="POST" >
                            @csrf
                            <input type="hidden" name="seleccion" value="2">
                            <div class="d-flex justify-content-between row ">
                                <div class="mb-3 col-7 border">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" name="name" class="form-control text-uppercase" id="name" minlength="2" s
                                        aria-describedby="nameHelp" required>
                                    <div id="nameHelp" class="form-text">Nombre completo o parcial.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <br>
                                    <button type="submit" class="btn btn-primary col-5 ">Buscar comerciante por nombre </button> 
                                </div>
                                
                            </div>
                        </form>

                        <form action="{{ route('lComerciantes') }}" method="POST" >
                            @csrf
                            <input type="hidden" name="seleccion" value="3">
                            <div class="d-flex justify-content-between row ">
                                <div class="mb-3 col-12 ">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <button type="submit" class="btn btn-secondary col-4 ">Lista de todos los comerciantes activos</button> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
    @endsection

@endsection