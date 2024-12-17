@extends('layouts.carcasa')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registrar el monto para el cobro del año fiscal.</div>

                    <div class="card-body">
                        <div class="d-flex justify-content-start">
                            <a href="{{ route('amounts.index') }}" class="btn btn-secondary d-flex align-items-end">Regresar</a>
                        </div>
                        <br>
                        <form action="{{ route('montos.store') }}" method="POST" class="col-12">
                            @csrf
                            <div class="row col-5">
                                <div class="col-12">
                                    <div class="mb-3 col-12" >
                                        <label for="CostOfSpace" class="form-label"> Monto por metro cuadrado: </label>
                                        $<input type=number step=0.01 name="monto" autocomplete="off" autofocus="on" min=0 
                                            class="form-control" id="CostOfSpace" aria-describedby="costHelp" placeholder="X.YY" 
                                            required>
                                        <div id="costHelp" class="form-text">Formato: solo números con 2 decimales.</div>
                                        @error('monto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Error de datos en el monto</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="fiscalYear" class="form-label"> Año fiscal: </label>
                                    <input type="number" step=1 name="year" autocomplete="off" min=2015 max="{{ now()->year + 1 }}" 
                                        class="form-control" id="year" required>
                                    @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Error de datos en el año</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">  
                                    <label for="regulation" class="form-label">Disposición administrativa: </label>
                                    <select name="regulation" id="regulation" class="form-control text-uppercase" required>
                                        <option value="" disabled selected>Seleccione la disposición</option>
                                        @foreach ($regulations as $regulation)
                                            <option value="{{ $regulation->regulation_id }}" class="text-uppercase"> 
                                                {{ $regulation->regulation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                
                                </div>
                                <div class="mb-3 form-check col-12 ms-3">
                                    <input type="checkbox" class="form-check-input" id="checkBox" required>
                                    <label class="form-check-label" for="checkBox">He verificado y quiero ingresar un monto para el nuevo año fiscal</label>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Registar Monto</button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
