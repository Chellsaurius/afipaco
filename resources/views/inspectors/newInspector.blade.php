@extends('layouts.carcasa')

@section('css')
@endsection

@section('title')
    <title>Nuevo inspector</title>
@endsection

@section('content')<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar un nuevo inspector</div>
                <br>
                <div class="d-flex justify-content-start ms-3">
                    <a href="{{ route('inspectors.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left-long"></i> Regresar
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('inspector.store') }}" method="POST" class="border">
                        @csrf
                        
                        <div class="mb-3 col-7">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" name="name" class="form-control text-uppercase  @error('name') is-invalid @enderror " value="{{ old('name') }}"
                                id="name" aria-describedby="nameHelp" autocomplete="off" autofocus="on" required>
                            <div id="nameHelp" class="form-text">Ingrese el o los nombres.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-7">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" class="form-control text-uppercase  @error('email') is-invalid @enderror " value="{{ old('email') }}"
                                id="email" aria-describedby="emailHelp" autocomplete="off"  size="30" required>
                            <div id="emailHelp" class="form-text">Ingrese el correo electrónico de la persona.</div>
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-7">
                            <label for="pass">Nueva contraseña</label>
                            <input type="password" name="pass" class="form-control col-6" id="pass" 
                                aria-describedby="passlHelp" placeholder="Nueva contraseña" required>
                            <small id="passlHelp" class="form-text text-muted">Minimo 8 caracteres.</small>
                        </div>
        
                        <div class="mb-3 col-7">
                            <label for="pass_confirmation">Verifique la contraseña</label>
                            <input type="password" name="pass_verified" class="form-control col-6" id="pass_confirmation" 
                            aria-describedby="vPasslHelp" placeholder="Verifique la contraseña" required>
                        </div>
                        
                        <div class="mb-3 form-check col-6">
                            <input type="checkbox" class="form-check-input" id="checkBox" required>
                            <label class="form-check-label" for="checkBox">He verificado y quiero ingresar un nuevo inspector.</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Registar inspector</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('js')
    @endsection
@endsection