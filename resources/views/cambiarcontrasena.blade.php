@extends('layouts.carcasa')

@section('content')
<div class="container">
  <div class="card shadow">
  
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-12">
                <h3 class="mb-0">Cambio de contraseña</h3>
                <br>
            </div>
            <form class="col-md-6 mb-3" action="{{ route('guardarContrasena') }}" method="POST">
              @csrf
                <input type="hidden" name="user" value="{{ Auth()->user()->id }}">
                <div class="form-group">
                  <label for="lastPass">Anterior contraseña</label>
                  <input type="password" name="lastPass" class="form-control col-6 " id="lastPass" aria-describedby="lPasslHelp" 
                    placeholder="Anterior contraseña" autofocus="on"  required>
                  <small id="lPasslHelp" class="form-text text-muted">Ingrese su anterior contraseña.</small>
                </div>

                <div class="form-group">
                  <label for="newPass">Nueva contraseña</label>
                  <input type="password" name="newPass" class="form-control col-6" id="newPass" 
                      aria-describedby="nPasslHelp" placeholder="Nueva contraseña" required>
                  <small id="nPasslHelp" class="form-text text-muted">Minimo 8 caracteres.</small>
                </div>

                <div class="form-group">
                    <label for="newPass_confirmation">Verifique la contraseña</label>
                    <input type="password" name="newPass_verified" class="form-control col-6" id="newPass_confirmation" 
                      aria-describedby="nVPasslHelp" placeholder="Verifique la contraseña" required>
                </div>
                <br>
                <br>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input " id="exampleCheck1" required>
                  <label class="form-check-label" for="exampleCheck1">He verificado los datos</label>
                </div>
                <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection