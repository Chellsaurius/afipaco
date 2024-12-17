@extends('layouts.carcasa')
<title>Panel de pagos</title>
@section('content')
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header">Panel de pagos</div>

                    <div class="card-body">
                        
                        <form action="{{ route('payment.list') }}" method="POST">
                            @csrf
                            <input type="hidden" name="seleccion" value="1">
                            <div class="mb-3 col-12 form-control">
                                <div class="mb-3 col-5">
                                    <label for="curp" class="form-label">CURP</label>
                                    <input type="text" name="curp" class="form-control text-uppercase" id="curp"
                                        aria-describedby="curpHelp">
                                    <div id="curpHelp" class="form-text">CURP del comerciante para buscar sus pagos.</div>
                                    @error('merchant_curp')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <br>
                                    <button type="submit" class="btn btn-primary col-12 ">Buscar pagos del comerciante por
                                        CURP </button>
                                </div>

                            </div>
                        </form>
                        <hr>
                        <form action="{{ route('payment.list') }}" method="POST" >
                            @csrf
                            <input type="hidden" name="seleccion" value="4">
                            <div class="mb-3 col-12 form-control">
                                <div class="mb-3 col-7">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" name="name" class="form-control text-uppercase" id="name" minlength="2" s
                                        aria-describedby="nameHelp" required>
                                    <div id="nameHelp" class="form-text">Nombre completo o parcial.</div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <br>
                                    <button type="submit" class="btn btn-primary col-5 ">Buscar pagos del comerciante</button> 
                                </div>
                                
                            </div>
                        </form>
                        <hr>
                        <form action="{{ route('payment.list') }}" method="POST">
                            @csrf
                            <input type="hidden" name="seleccion" value="2">
                            <div class="mb-3 col-12 form-control">
                                <div class="row ">
                                    <div class="@error('dia') is-invalid @enderror"></div>
                                    <label for="dias" class="form-label" aria-describedby="diasHelp">Buscar pagos por categoría</label>
                                    
                                    @foreach ($categories as $category)
                                        <div class="d-flex justify-content-left col-4 wrap border align-items-center p-2">
                                            <input type="checkbox" name="categories[]" id="{{ $category->category_type }}"
                                                value="{{ $category->category_id }}" class="form-check-input m-1">
                                            <label class="form-check-label"
                                                for="{{ $category->category_type }}">{{ $category->category_type }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary col-3 ">Buscar pagos según categoría(s)
                                </button>
                            </div>
                        </form>
                        <form action="{{ route('payment.list') }}" method="POST">
                            @csrf
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <hr>
                            <input type="hidden" name="seleccion" value="3">
                            <div class="d-flex justify-content-between row ">
                                <div class="mb-3 col-6 ">
                                    <button type="submit" class="btn btn-secondary col-6 ">Lista de todos los pagos activos</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $("#generar").click(function() {
                from = document.getElementById('initialDateRQ').value,
                    to = document.getElementById('finalDateRQ').value,
                    //console.log(token, from, to)    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                $.ajax({
                    type: "POST",
                    url: '/mostrarReporte',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        from: from,
                        to: to,
                    }

                }).done(function(respuesta) {
                    //console.log(respuesta)
                    var clase = [];
                    var total = [];
                    for (let index = 0; index < respuesta.length; index++) {
                        clase[index] = respuesta[index].clase
                        total[index] = respuesta[index].total
                    }
                    //console.log(clase, total)

                    if (clase[0] != null && total[0] != null) {
                        $("#mostrarA").val(clase[0] + ": $" + total[
                        0]); // ID de la 1era caja de texto
                    } else {
                        $("#mostrarA").val("No hay.");
                    }
                    if (clase[1] != null && total[1] != null) {
                        $("#mostrarS").val(clase[1] + ": $" + total[
                        1]); // ID de la 2da caja de texto
                    } else {
                        $("#mostrarS").val("No hay.");
                    }

                    if (clase[2] != null && total[2] != null) {
                        $("#mostrarT").val(clase[2] + ": $" + total[
                        2]); // ID de la 3ra caja de texto
                    } else {
                        $("#mostrarT").val("No hay.");
                    }
                })

            });

        });
    </script>
    <script>
        function show_my_receipt() {

            var t = document.getElementById('tianguis');
            var s = document.getElementById('semifijo');
            var a = document.getElementById('ambulante');
            var from = document.getElementById('initialDateR').value;
            var to = document.getElementById('finalDateR').value;

            if (t.checked == true) {
                var t = 1;
            } else {
                var t = 0;
            }
            if (s.checked == true) {
                var s = 2;
            } else {
                var s = 0;
            }
            if (a.checked == true) {
                var a = 3;
            } else {
                var a = 0;
            }
            //alert(t + s+ a+ from+ to)

            // open the page as popup //
            var page = 'http://localhost:8000/ajaxMostrarReporte/' + t + '/' + s + '/' + a + '/' + from + '/' + to;
            //var page = 'https://afipaco.salamanca.gob.mx/ajaxMostrarReporte/' + t + '/' + s + '/' + a + '/' + from + '/' + to; 

            var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=1000,top=50");

            // focus on the popup //
            myWindow.focus();

            // if you want to close it after some time (like for example open the popup print the receipt and close it) //

            //  setTimeout(function() {
            //    myWindow.close();
            //  }, 1000);

        }
    </script>
@endsection
