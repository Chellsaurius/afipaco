<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet"/>
    <style>
        .headt td {
            min-width: 200px;
            height: 30px;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <title>DIRECCIÓN DE FISCALIZACIÓN Y CONTROL</title>
    <div style="margin: 5px" class="d-flex justify-content-between">
        <a class="btn btn-primary" onclick="window.open('', '_self', ''); window.close();"> Regresar</a>
        <a class="btn btn-primary" onclick="vista('printArea')"> Imprimir comprobante</a>
    </div>
    <div class="container" id="printArea" >
        
        @foreach ($pagos as $pago)
            <br>
            <br>
            <legend class="text-center text-white" 
                style="background-color: grey !important; padding-bottom: 10px; padding-right: 10px; margin-bottom: -10px;">
                DIRECCIÓN DE FISCALIZACIÓN Y CONTROL
            </legend>

            <br>
            <br>
            <br>
            <form class="row g-1 border" action="#" style="padding: 3px;">
                <div class="d-flex flex-row-reverse mb-1" >
                    <div class="mt-2 border border-dark" style="height: 26px; width: 300px">
                        <p class=""> &nbsp; FOLIO: {{ $pago->payment_folio }}</p>
                    </div>
                </div>
                <div class="col-6  rounded text-center" style="height: 26px">
                    <label for="nombre" class="form-label" >ORDEN DE PAGO</label>
                    
                </div>
                <div class="col-6  rounded text-center" style="height: 26px">
                    <label for="apellidos" class="form-label">FECHA DE EXPEDICIÓN: &nbsp; {{ date("d-m-Y", strtotime($pago->updated_at) ) }} </label>
                    
                </div>
                
                <br>
                <br>
                <div class="col-12  rounded pb-" style="height: 38px">
                    <p style="font-size: 10px; margin-bottom: 10px;" class="text-uppercase"> EL CIUDADANO: <b style="font-size: 14px"> &nbsp; <u> {{ $pago->payment_name }}</u> </b>
                        <br>
                        EFECTUA EL PAGO EN LA TESORERÍA MUNICIPAL POR LA CANTIDAD DE: <b style="font-size: 14px"> &nbsp; $<u> {{ $pago->payment_amount }} MXN</u></b> 
                        &nbsp; &nbsp; POR EL CONCEPTO DE:
                    </p>
                    
                </div>
                <br>
                <br>
                <br>
                <div class="col-12 rounded pb-1 d-flex justify-content-evenly row  ">
                    <div style="height: 34px">
                        <p><b>DISPOSICIONES ADMINISTRATIVAS DE RECAUDACIÓN PARA EL MUNICIPIO DE SALAMANCA, GUANAJUATO, PARA EL EJERCICIO FISCAL {{ date('Y') }} </b></p>
                    </div>
                    <div class="col-6  d-flex justify-content-center row align-items-center p-1">
                        <div class=" d-flex justify-content-start" style="height: 32px">
                            <p style="font-size: 10px ">1.- ART. 8 LA OCUPACIÓN Y PROVECHAMIENTO DE LA VÍA PÚBLICA POR LOS PARTICULARES:</p>
                        </div>
                        @if ($pago->payment_category <> 'Ocasional')
                            <div class=" d-flex justify-content-between " style="height: 24px">
                                <p class="col col-11 mt-1" style="font-size: 10px "> FRACCIÓN I DE LAS DISPOSICIONES ADMINISTRATIVAS</p>
                                <div class=" border border-dark col-1 mt-1" style="height: 15px; width: 28px"> </div>
                                <div class="col col-1 " style="height: 25px; width: 58px; margin-left:-20px "> <i class="fa-solid fa-xmark"></i> </div>
                            </div>
                            <div class=" d-flex justify-content-start" style="height: 24px">
                                <p class="col col-11 align-middle mt-1" style="font-size: 10px "> FRACCIÓN II</p>
                                <div class=" border border-dark col-1 mt-1" style="height: 15px; width: 28px"></div>
                            </div>
                        @else
                            <div class=" d-flex justify-content-between " style="height: 24px">
                                <p class="col col-11 mt-1" style="font-size: 10px "> FRACCIÓN I DE LAS DISPOSICIONES ADMINISTRATIVAS</p>
                                <div class=" border border-dark col-1 mt-1" style="height: 15px; width: 28px"> </div>
                                <div class="col col-1 " style="height: 25px; width: 58px; margin-left:-20px "> 
                                    {{-- por alguna razón no pude acomodar la X en la racción correcta, el margen de la base no me fuinciona así
                                    que tuve que hacerlo aquí con un margen top, no sé por qué... --}}
                                    <div class="pt-4 mt-1">     
                                        <i class="fa-solid fa-xmark "></i>
                                    </div> </div>
                                
                            </div>
                            <div class=" d-flex justify-content-start " style="height: 24px">
                                <p class="col col-11 align-middle mt-1" style="font-size: 10px "> FRACCIÓN II</p>
                                <div class=" border border-dark col-1 mt-1" style="height: 15px; width: 28px"></div>
                            </div>
                        @endif
                        @if ($pago->payment_category == 'Ocasional' && $pago->payment_extraMeters > 0)
                            <div class=" d-flex justify-content-start" style="height: 24px">
                                <p class="col col-11 align-middle mt-1" style="font-size: 10px "> FRACCIÓN III</p>
                                <div class=" border border-dark col col-1 mt-1" style="height: 15px; width: 28px"></div>
                                <div class="col col-1 " style="height: 25px; width: 58px; margin-left:-20px "> <i class="fa-solid fa-xmark"></i> </div>
                            </div>
                        @else
                            <div class=" d-flex justify-content-start" style="height: 24px">
                                <p class="col col-11 align-middle mt-1" style="font-size: 10px "> FRACCIÓN III</p>
                                <div class=" border border-dark col col-1 mt-1" style="height: 15px; width: 28px"></div>
                            </div>
                        @endif
                        
                    </div>
                    
                </div>
                <br><br><br><br><br><br><br><br>
                
                <div class="col-12  rounded pb-1 mt-2 text-uppercase" style="height: 24px">
                    <p style="font-size: 14px; "> LUGAR: &nbsp; <b> {{ $pago->payment_place }} </b> </p>
                    
                </div>
                <br>
                <br>
                <div class="col-md-12">
                    <div class="col-12  rounded d-flex justify-content-start row mx-1 border border-3 border-dark" style="height: auto">
                        <p style="font-size: 14px; " class="d-flex align-items-center col-12"> 
                            <b> CALCULOS </b>   
                        </p>
                        <p class="d-flex align-items-center col-12 text-uppercase" style="font-size: 14px;" >
                            DÍAS LABORADOS = {{ $pago->payment_daysWorked }} * COSTO FISCAL =  ${{ $pago->payment_fiscalAmount }} * {{ $pago->payment_dimentions }} @if ($pago->payment_fiscalAmountExtraMeters <> 0) (${{ $pago->payment_fiscalAmountExtraMeters }})@endif, TOTAL = ${{ number_format($pago->payment_amount, 2) }}
                        </p>
                    </div>
                </div>
                <div class="col-12  rounded pb-1" style="height: 86px">
                    <p style="font-size: 14px; " class="text-uppercase"> 
                        
                        @if ($pago->payment_category == 'Tianguista')
                            Nombre del tianguis: <b>{{ $pago->RPaymentsLocals->RLocalsTianguis->tiangui_name }} ({{ str_replace(',', ', ', $pago->payment_daysText) }}) </b>
                        @endif
                        @if ($pago->payment_category == 'Semifijo' || $pago->payment_category == 'Ambulante')
                            Días laborales: <b>{{ str_replace(',', ' ', $pago->payment_daysText) }} de {{ \Carbon\Carbon::parse($pago->payment_startingHour)->format('H:i') }} a {{ \Carbon\Carbon::parse($pago->payment_endingHour)->format('H:i') }}</b>
                        @endif                                                                                                      
                        @if ($pago->payment_category == 'Ocasional')|
                            Días laborales: <b>{{ str_replace(',', ' ', $pago->payment_daysText) }} de {{ \Carbon\Carbon::parse($pago->payment_startingHour)->format('H:i') }} a {{ \Carbon\Carbon::parse($pago->payment_endingHour)->format('H:i') }}</b>
                        @endif
                        
                        <br>
                        GIRO(S): <b> {{ trim($pago->payment_activities, ',') }} </b>
                        <br>
                        DENOMINACIÓN: 
                        <br>
                        VIGENCIA DEL: <b> {{ date('d-m-Y', strtotime($pago->payment_startingDate)) }} </b> AL: <b> {{ date('d-m-Y', strtotime($pago->payment_endingDate)) }} </b>
                    </p>
                    
                </div>
                <br>
                <br>
                <br>
                <div class="col-12 rounded pb-1 d-flex justify-content-center mt-5" style="height: 24px">
                    <p style="font-size: 14px; "> ATENTAMENTE </p>
                    <br>
                    <br>
                    <br>
                    
                </div>
                <div class="col-12 rounded pb-1 d-flex justify-content-center ">
                    <div style="height: 34px">
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    </div>
                    <div class="col-6 border d-flex justify-content-center row align-items-center ">
                        <div class=" col-12 border d-flex justify-content-center align-items-end" style="height: 82px">
                            
                            <hr size="6" width="400px" align="center  " color="red">
                        </div>
                        <div class=" col-12 border d-flex justify-content-center " >
                            
                            <p class="d-flex justify-content-center" style="font-size: 10px; height: 36px"> <br> 
                                LIC. JUAN GERSON ORTA DE LUNA
                                <br>
                                DIRECTOR DE FISALIZACIÓN Y CONTROL
                            </p>
                            
                        </div>
                    
                        
                    </div>
                    
                </div>
                
            </form>
            <br><br>
            <br><br>
            <br>
        @endforeach
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    function vista(printArea) {
        var content = document.getElementById(printArea).innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = content;

        window.print();

        document.body.innerHTML = originalContent;
    }
</script>
</html>