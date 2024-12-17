<div class="modal fade" id="pagarModal{{ $local->local_id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Generar pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="formulario">
                    <input type="hidden" name="merchant_id" id="merchant_id" value="{{ $local->merchant_id }}">
                    <input type="hidden" name="local_id" id="local_id" value="{{ $local->local_id }}">
                    <input type="hidden" name="payment_id" id="payment_id" value="{{ $pagos->payment_id }}">
                    <div class="d-flex justify-content-between row ">
                        <div class="mb-3 col-4 border">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" class="form-control text-uppercase"
                                value="{{ $local->merchant_names }}" id="name" aria-describedby="nameHelp"
                                readonly>
                            <div id="nameHelp" class="form-text">Nombre del que pagó.</div>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-5 border">
                            <label for="business" class="form-label">Giro</label>
                            <input type="text" name="business" class="form-control"
                                value="{{ $local->merchant_activity }}" id="business" aria-describedby="businessHelp"
                                readonly hidden>
                            <input type="text" class="form-control"
                                value="{{ trim($local->merchant_activity, ',') }}" readonly>
                            <div id="businessHelp" class="form-text">Giro(s).</div>
                            @error('business')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="curp" class="form-label">CURP</label>
                            <input type="text" name="curp" class="form-control" id="curp"
                                value="{{ $local->merchant_curp }}" aria-describedby="folioHelp" readonly>
                            <div id="curpHelp" class="form-text">Clave única de registro de población. </div>

                        </div>
                        <div class="mb-3 col-12 border">
                            <label for="ubication" class="form-label">Ubicación</label>
                            <input type="text" name="ubication" class="form-control"
                                value="{{ $local->local_location }}" id="ubication" aria-describedby="ubicationHelp"
                                readonly>
                            <div id="ubicationHelp" class="form-text">Ubicación del local.</div>
                            @error('ubication')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-6 border">
                            <label for="days" class="form-label">Dias</label>
                            <input type="text" class="form-control" id="days" value="{{ $local->dia }}"
                                hidden>
                            <input type="text" class="form-control"
                                @if ($local->dia == 1) value="LUNES" @endif
                                @if ($local->dia == 2) value="MARTES" @endif
                                @if ($local->dia == 3) value="MIÉRCOLES" @endif
                                @if ($local->dia == 4) value="JUEVES" @endif
                                @if ($local->dia == 5) value="VIERNES" @endif
                                @if ($local->dia == 6) value="SÁBADO" @endif
                                @if ($local->dia == 7) value="DOMINGO" @endif readonly>
                            <div id="daysHelp" class="form-text">Dias que labora el comerciante.</div>
                            @error('days')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3 col-3 border">
                            <label for="cost" class="form-label">Monto fiscal: </label>
                            <select name="cost" id="cost{{ $local->local_id }}" class="form-control"
                                onchange="newValue({{ $local->local_id }})" aria-describedby="montoHelp">
                                <option value="" disabled selected>Seleccione un monto</option>
                                @foreach ($montos as $monto)
                                    <option value="{{ $monto->amount_cost }}">Año: {{ $monto->amount_year }} -
                                        Precio: ${{ number_format($monto->amount_cost, 2) }}</option>
                                @endforeach

                            </select>
                            <div id="montoHelp" class="form-text">Monto con el que se cobrará al comerciante.</div>
                        </div>
                        <div class="mb-3 col-3 border col align-self-center" id="FI{{ $local->local_id }}"
                            style="display:none">
                            <label for="IDatePayment" class="form-label"> Selecciona la fecha de inicio. </label>
                            <input type="date" id="IDatePayment{{ $local->local_id }}" name="IDatePayment"
                                class="form-control" aria-describedby="iDateHelp"
                                onchange="activateDateEnd({{ $local->local_id }})" required>
                            <div id="iDateHelp" class="form-text">Fecha en la que inicia el permiso. </div>
                        </div>
                        <div class="mb-3 col-3 border col align-self-center">
                            <label for="FDatePayment" class="form-label"> Selecciona la fecha de finalización.
                            </label>
                            <input type="date" id="FDatePayment{{ $local->local_id }}" name="FDatePayment"
                                disabled="disabled" class="form-control" aria-describedby="fDateHelp"
                                onchange="daysDifference({{ $local->local_id }})" required>
                            <div id="fDateHelp" class="form-text">Fecha en la que termina el permiso.</div>
                        </div>

                        <div class="mb-3 col-3 border">
                            <label for="measurements" class="form-label">Medidas.</label>
                            <input type="text" id="dim{{ $local->local_id }}"
                                value="{{ $local->local_dimx * $local->local_dimy }} " hidden>
                            <input type="text" name="measurment" class="form-control"
                                id="measurements{{ $local->local_id }}"
                                value="{{ $local->local_dimx }} x {{ $local->local_dimy }}"
                                aria-describedby="measurementsHelp" disabled>
                            <div id="measurementHelp" class="form-text">Medidas del local del comerciante. </div>
                        </div>

                        <div class="mb-3 col-3 border">
                            <label for="value" class="form-label">Cantidad del pago por los día. $</label>
                            <input type="number" name="value" class="form-control"
                                id="value{{ $local->local_id }}" value="" aria-describedby="valueHelp"
                                readonly>
                            <div id="valueHelp" class="form-text">Cantidad que el ciudadano va a pagar. </div>

                        </div>

                        <div class="mb-3 col-3 border">
                            <label for="dWorked" class="form-label">Días laborados: </label>
                            <input type="text" name="dWorked" class="form-control"
                                id="dWorked{{ $local->local_id }}" aria-describedby="dWorkedHelp" readonly>
                            <div id="dWorkedHelp" class="form-text">Cantidad de días que el ciudadano trabajó. </div>

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
                <div class="mb-3 col-10 ">
                    <div class="mb-3 ml-10 form-check ">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                        <label class="form-check-label" for="exampleCheck1">Los datos son correctos</label>
                    </div>
                    <button class="btn btn-primary col-3 " onclick="show_my_receipt()">Generar pago</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>


@section('js')
    <script>
        function activateDateEnd(activation) {
            //console.log(activation)
            if (this.value == '0') {
                document.getElementById("FDatePayment" + activation).disabled = true;
            } else {
                document.getElementById("FDatePayment" + activation).disabled = false;

            }
        }
    </script>
    <script>
        function newValue(id) {

            var monto = document.getElementById("dim" + id).value;
            var costo = document.getElementById("cost" + id).value;
            var fi = document.getElementById("FI" + id);
            //alert (monto * costo);
            //console.log(fi)

            let total = monto * costo;

            var result = document.getElementById("value" + id);
            result.value = total.toFixed(2);

            fi.style.display = "block";
        }
    </script>
    <script>
        function daysDifference(id) {
            //define two variables and fetch the input from HTML form  
            var dateI1 = document.getElementById("IDatePayment" + id).value;
            var dateI2 = document.getElementById("FDatePayment" + id).value;
            var costo = document.getElementById("value" + id).value;

            //console.log('leyó las variables')
            //define two date object variables to store the date values  
            var date1 = new Date(dateI1);
            var date2 = new Date(dateI2);

            var ano1 = date1.getFullYear();
            var ano2 = date2.getFullYear();
            if (date1 >= date2) {
                alert('La fecha final es menor a la fecha de inicio')
            }

            //if (ano1 == ano2) {
            result = 'positive';
            //calculate time difference  
            var time_difference = date2.getTime() - date1.getTime();

            //calculate days difference by dividing total milliseconds in a day  
            var result = time_difference / (1000 * 60 * 60 * 24);
            var result = result + 1;

            var dias = document.getElementById("days").value;

            const cadena = dias.split(",");
            //console.log(cadena[0])

            const start = new Date(date1);
            const end = new Date(date2);
            const weekday = ["7", "1", "2", "3", "4", "5", "6"];
            var counter = 0;
            //console.log(start)
            let loop = new Date(start);
            do {

                let newDate = loop.setDate(loop.getDate() + 1);
                loop = new Date(newDate);
                for (let index = 0; index < cadena.length; index++) {

                    if (weekday[loop.getDay()] == cadena[index]) {
                        counter = counter + 1;
                        //console.log("entró al día: " + cadena[index])
                        //console.log("contador: " + counter)
                    }
                }

                //console.log(weekday[loop.getDay()]);
            } while (loop <= end);
            let total = counter * costo;

            var result = document.getElementById("dWorked" + id);
            result.value = counter;

            var result = document.getElementById("total" + id);
            result.value = total.toFixed(2);
            /*
                } else {
                    result = 'NOT positive';
                    alert ("Los años son distintos.");  
                } */
            //return document.getElementById("result").innerHTML = total;  
        }
    </script>
    <script>
        function show_my_receipt() {
            var payment_id = document.getElementById("payment_id").value;
            var url = '/ajaxGuardarPago';
            var id = document.getElementById('local_id').value;
            var folio = null;
            var curp = document.getElementById('merchant_curp').value;
            var costo = document.getElementById('total' + id).value;
            var IDatePayment = document.getElementById('IDatePayment' + id).value;
            var FDatePayment = document.getElementById('FDatePayment' + id).value;
            var dWorked = document.getElementById('dWorked' + id).value;
            var merchant_id = document.getElementById('merchant_id').value;
            //console.log(id, payment_id, curp, costo, IDatePayment, FDatePayment, dWorked, merchant_id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    local_id: id,
                    folio: folio,
                    curp: curp,
                    costo: costo,
                    IDatePayment: IDatePayment,
                    FDatePayment: FDatePayment,
                    dWorked: dWorked,
                    merchant_id: merchant_id,
                }
            }).done(function(payments) {
                //console.log(payments)

                // open the page as popup //

                var page = 'http://localhost:8000/imprimirPago/' + payments.payment_id;
                //var page = 'https://afipaco.salamanca.gob.mx/imprimirPago/' + payments.payment_id; 

                var myWindow = window.open(page, "_blank", "scrollbars=yes,width=800,height=1000,top=50");

                // focus on the popup //
                myWindow.focus();

                // if you want to close it after some time (like for example open the popup print the receipt and close it) //

                //  setTimeout(function() {
                //    myWindow.close();
                //  }, 1000);

                location.href = 'http://localhost:8000/ListaPagosPendientes';
                //location.href = 'https://afipaco.salamanca.gob.mx/ListaPagosPendientes';
            })

        }
    </script>
@endsection
