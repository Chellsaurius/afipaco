@extends('layouts.carcasa')

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
                    <div class="card-header">Lista de centros historicos</div>

                    <div class="card-body">
                        <div class="d-flex align-content-start flex-wrap">
                            <a href="{{ route('maket.index') }}" class="btn btn-secondary">Regresar</a>
                        </div>
                        <br>
                        <br>
                        <form action="{{ route('market.save') }}" method="post">
                            @csrf
                            <div class="col-12 row">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Nombre</span>
                                    <input type="text" name="name" class="form-control text-uppercase" aria-label="Sizing example input" 
                                        aria-describedby="marketName" placeholder="Ejemplo: Jardin Xidou" autofocus required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-4 ">
                                    <label for="IHourTianguis" class="form-label"> Selecciona la hora de inicio. </label>
                                    <input type="time" id="startingHour" name="startingHour" class="form-control"
                                        aria-describedby="startingHour" min="01:00" max="23:59" required>
                                    <div id="startingHour" class="form-text">Formato: 12 horas. </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-4 ">
                                    <label for="FHourTianguis" class="form-label"> Selecciona la hora de finalización. </label>
                                    <input type="time" id="endingHour" name="endingHour" class="form-control"
                                        aria-describedby="endingHour" min="01:00" max="24:00" required>
                                    <div id="endingHour" class="form-text">Formato: 12 horas.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-12 ms-3">
                                    <div class="mb-3 form-check col-5 ">
                                        <input type="checkbox" class="form-check-input" id="TFinalCheck" required>
                                        <label class="form-check-label" for="TFinalCheck">Los datos del lugar son correctos </label>
                                    </div>
                                </div>
                                <div class="col-12 ml-4 ps-4">
                                    <button type="submit" class="btn btn-primary col-3">Guardar</button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
